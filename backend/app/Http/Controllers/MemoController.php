<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

class MemoController extends Controller
{
    // 一覧取得（認証ユーザーのメモのみ）
    public function index(Request $request)
    {
        return $request->user()
            ->memos()
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'content', 'created_at']);
    }

    // 新規作成
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:100',
            'content' => 'required|string',
        ]);
        $memo = $request->user()->memos()->create($data);
        return response()->json($memo, 201);
    }
}
