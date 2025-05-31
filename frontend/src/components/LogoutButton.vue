<template>
    <button @click="logout">ログアウト</button>
  </template>
  
  <script setup lang="ts">
  import { useRouter } from 'vue-router'
  import axios from 'axios'
  
  const router = useRouter()
  
  const logout = async () => {
    await axios.post('/api/logout')
    await router.push('/login')
  }
  </script>
  