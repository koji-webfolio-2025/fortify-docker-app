<template>
    <div>
      <h2>ユーザー情報</h2>
      <div v-if="user">
        <p>ID: {{ user.id }}</p>
        <p>メールアドレス: {{ user.email }}</p>
        <p>名前: {{ user.name }}</p>
      </div>
      <div v-else>
        ユーザー情報を取得中...
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  const user = ref<any>(null)
  
  onMounted(async () => {
    try {
      const res = await axios.get('/api/user')
      console.log('APIレスポンス:', res.data)
      user.value = res.data
    } catch {
      user.value = null
    }
  })
  </script>
  