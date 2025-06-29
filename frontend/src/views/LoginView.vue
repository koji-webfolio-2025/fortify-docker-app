<template>
    <div class="login-container">
      <h2>ログイン01</h2>
      <form @submit.prevent="handleLogin">
        <div>
          <label for="email">メールアドレス</label>
          <input id="email" v-model="email" type="email" required />
        </div>
        <div>
          <label for="password">パスワード</label>
          <input id="password" v-model="password" type="password" required />
        </div>
        <button type="submit">ログイン</button>
        <div v-if="error" class="error">{{ error }}</div>
      </form>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue'
  import axios from 'axios'
  
  const email = ref('')
  const password = ref('')
  const error = ref('')

  function getCookie(name: string) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop()!.split(';').shift();
  }
  
  const handleLogin = async () => {
    error.value = ''
    try {
      await axios.get('/sanctum/csrf-cookie',{ withCredentials: true }) // CSRFトークン取得
      await axios.post('/login', {
        email: email.value,
        password: password.value,
      },{
      headers: {
        // XSRF-TOKENを明示的に付与（自動で付与されない場合の対策）
        'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN') ?? '')
      }
    })
      window.location.href = '/user'
    } catch (e: any) {
      error.value = e.response?.data?.message || 'ログインに失敗しました'
    }
  }
  </script>
  
  <style scoped>
  .error { color: red; }
  </style>
  