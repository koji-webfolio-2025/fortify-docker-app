<template>
    <div class="login-container">
      <h2>ログイン</h2>
      <form @submit.prevent="handleLogin">
        <div>
          <label for="email">メールアドレス</label>
          <input id="email" v-model="email" type="email" required />
        </div>
        <div>
          <label for="password">パスワード</label>
          <input id="password" v-model="password" type="password" required />
        </div>
        <button type="submit">ログインテスト2</button>
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
  
  const handleLogin = async () => {
    error.value = ''
    try {
      await axios.get('/sanctum/csrf-cookie') // CSRFトークン取得
      await axios.post('/login', {
        email: email.value,
        password: password.value,
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
  