<template>
  <div>
    <h2>日報・メモ管理</h2>

    <!-- 新規メモ追加フォーム -->
    <form @submit.prevent="submitMemo">
      <div>
        <input v-model="form.title" placeholder="タイトル" maxlength="100" required />
      </div>
      <div>
        <textarea v-model="form.content" placeholder="内容" required rows="3"></textarea>
      </div>
      <button type="submit">登録</button>
    </form>

    <hr />

    <!-- メモ一覧 -->
    <h3>投稿一覧</h3>
    <div v-if="memos.length === 0">まだメモがありません。</div>
    <ul>
      <li v-for="memo in memos" :key="memo.id" style="margin-bottom: 1em;">
        <strong>{{ formatDate(memo.created_at) }}</strong>
        <div><b>{{ memo.title }}</b></div>
        <div>{{ memo.content }}</div>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

interface Memo {
  id: number
  title: string
  content: string
  created_at: string
}

const memos = ref<Memo[]>([])

const form = ref({
  title: '',
  content: ''
})

// 日付表示整形
function formatDate(dt: string) {
  const d = new Date(dt)
  return d.toLocaleDateString() + ' ' + d.toLocaleTimeString()
}

// メモ一覧取得
async function fetchMemos() {
  const res = await axios.get('/api/memos')
  memos.value = res.data
}

// CookieからXSRF-TOKENを取得する関数を追加
function getCookie(name: string) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop()!.split(';').shift();
}

// 新規登録
async function submitMemo() {
  if (!form.value.title || !form.value.content) return
  try {
    // 必要ならPOST直前にCSRFトークンを明示付与
    const res = await axios.post('/api/memos', form.value, {
      withCredentials: true,
      headers: {
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN') ?? '')
      }
    })
    memos.value.unshift(res.data)
    form.value.title = ''
    form.value.content = ''
  } catch (e: any) {
    alert('登録に失敗しました: ' + (e?.response?.data?.message ?? 'エラー'))
  }
}

onMounted(() => {
  fetchMemos()
})
</script>
