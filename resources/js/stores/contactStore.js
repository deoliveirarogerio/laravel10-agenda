import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'

export const useContactStore = defineStore('contact', () => {
  const contacts = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function fetchContacts() {
    loading.value = true
    error.value = null
    try {
      const response = await axios.get('/api/contacts')
      contacts.value = response.data
    } catch (err) {
      error.value = err
    } finally {
      loading.value = false
    }
  }

  return { contacts, loading, error, fetchContacts }
})