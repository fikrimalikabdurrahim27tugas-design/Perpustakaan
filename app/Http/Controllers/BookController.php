<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookController extends Controller
{
    // Menampilkan Katalog Buku + Filter Kategori + Pencarian
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = DB::table('books');

        if ($category) {
            $query->where('category', strtolower($category));
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->orderBy('title', 'asc')->get();

        return view('books.index', compact('books', 'category', 'search'));
    }

    // Proses Peminjaman Buku
    public function borrow($id)
    {
        $userId = Auth::id();
        $book = DB::table('books')->where('id', $id)->first();

        if (!$book) {
            return back()->with('error', 'Buku tidak ditemukan.');
        }

        if ($book->stock <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        // Cek apakah siswa masih punya denda yang belum dibayar
        $hasUnpaidFine = DB::table('fines')
            ->where('user_id', $userId)
            ->where('status', 'unpaid')
            ->exists();

        if ($hasUnpaidFine) {
            return back()->with('error', 'Anda memiliki denda keterlambatan yang belum lunas. Lunasi di perpustakaan sebelum meminjam lagi.');
        }

        // Cek apakah siswa sedang meminjam buku yang sama
        $alreadyBorrowed = DB::table('loans')
            ->where('user_id', $userId)
            ->where('book_id', $id)
            ->where('status', 'borrowed')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Anda masih meminjam buku ini. Kembalikan terlebih dahulu sebelum meminjam lagi.');
        }

        // Cek batas maksimal pinjaman aktif (Maksimal 3 buku)
        $activeLoansCount = DB::table('loans')
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->count();

        if ($activeLoansCount >= 3) {
            return back()->with('error', 'Batas maksimal peminjaman adalah 3 buku aktif. Silakan kembalikan buku sebelumnya.');
        }

        DB::transaction(function () use ($userId, $id, $book) {
            DB::table('loans')->insert([
                'user_id' => $userId,
                'book_id' => $id,
                'loan_date' => Carbon::now()->toDateString(),
                'due_date' => Carbon::now()->addDays(7)->toDateString(),
                'status' => 'borrowed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('books')->where('id', $id)->update([
                'stock' => $book->stock - 1,
                'updated_at' => Carbon::now(),
            ]);
        });

        return redirect()->route('loans.index')->with('success', 'Berhasil meminjam buku "' . $book->title . '". Batas pengembalian 7 hari.');
    }

    // Menampilkan Daftar Pinjaman & Tagihan Denda Siswa
    public function myLoans()
    {
        $userId = Auth::id();

        $loans = DB::table('loans')
            ->join('books', 'loans.book_id', '=', 'books.id')
            ->where('loans.user_id', $userId)
            ->select('loans.*', 'books.title', 'books.author', 'books.category')
            ->orderBy('loans.created_at', 'desc')
            ->get();

        $totalUnpaidFine = DB::table('fines')
            ->where('user_id', $userId)
            ->where('status', 'unpaid')
            ->sum('amount');

        return view('books.loans', compact('loans', 'totalUnpaidFine'));
    }

    // Proses Pengembalian Buku & Perhitungan Denda Otomatis
    public function returnBook($loanId)
    {
        $userId = Auth::id();
        $loan = DB::table('loans')
            ->where('id', $loanId)
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->first();

        if (!$loan) {
            return back()->with('error', 'Data peminjaman tidak valid atau sudah dikembalikan.');
        }

        $today = Carbon::now()->startOfDay();
        $dueDate = Carbon::parse($loan->due_date)->startOfDay();
        
        // Hitung keterlambatan dalam hari (jika lewat due_date)
        $daysLate = $today->gt($dueDate) ? $dueDate->diffInDays($today) : 0;
        $fineAmount = $daysLate * 1000; // Denda Rp 1.000 per hari

        DB::transaction(function () use ($loan, $userId, $today, $daysLate, $fineAmount) {
            // 1. Ubah status peminjaman menjadi returned
            DB::table('loans')->where('id', $loan->id)->update([
                'status' => 'returned',
                'updated_at' => Carbon::now(),
            ]);

            // 2. Kembalikan stok buku (+1)
            DB::table('books')->where('id', $loan->book_id)->increment('stock');

            // 3. Catat ke tabel returns
            $returnId = DB::table('returns')->insertGetId([
                'loan_id' => $loan->id,
                'return_date' => $today->toDateString(),
                'days_late' => $daysLate,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // 4. Jika terlambat, catat tagihan denda ke tabel fines
            if ($fineAmount > 0) {
                DB::table('fines')->insert([
                    'return_id' => $returnId,
                    'user_id' => $userId,
                    'amount' => $fineAmount,
                    'status' => 'unpaid',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        });

        if ($fineAmount > 0) {
            return redirect()->route('loans.index')->with('warning', 'Buku dikembalikan terlambat ' . $daysLate . ' hari. Anda terkena denda sebesar Rp ' . number_format($fineAmount, 0, ',', '.') . '.');
        }

        return redirect()->route('loans.index')->with('success', 'Buku berhasil dikembalikan tepat waktu. Terima kasih!');
    }
}