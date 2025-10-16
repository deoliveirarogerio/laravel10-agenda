import { defineStore } from 'pinia';
import axios from 'axios';

const API = '/api/v1/contacts';

export const useContactsStore = defineStore('contacts', {
  state: () => ({
    items: [],
    pagination: { current_page: 1, last_page: 1, total: 0 },
    loading: false,
    selected: new Set(),
    q: '',
    lastError: null,
  }),
  actions: {
    toggleSelect(id) {
      if (this.selected.has(id)) this.selected.delete(id);
      else this.selected.add(id);
    },
    clearSelection() { this.selected.clear(); },

    async fetch(page = 1) {
      this.loading = true;
      this.lastError = null;
      try {
        const { data } = await axios.get(API, { params: { page, q: this.q || undefined } });
        this.items = data.data ?? data;
        this.pagination = {
          current_page: data.current_page ?? 1,
          last_page: data.last_page ?? 1,
          total: data.total ?? (Array.isArray(data) ? data.length : 0),
        };
      } catch (e) {
        console.error('Contacts fetch failed:', e);
        this.lastError = e?.response?.data || e?.message || 'Erro';
        this.items = [];
        this.pagination = { current_page: 1, last_page: 1, total: 0 };
      } finally {
        this.loading = false;
      }
    },

    async find(id) {
      const { data } = await axios.get(`${API}/${id}`);
      return data;
    },

    async create(payload) {
      const { data } = await axios.post(API, payload);
      this.items.unshift(data);
      return data;
    },

    async update(id, payload) {
      const { data } = await axios.put(`${API}/${id}`, payload);
      const idx = this.items.findIndex(i => i.id === data.id);
      if (idx !== -1) this.items[idx] = data;
      return data;
    },

    async remove(id) {
      await axios.delete(`${API}/${id}`);
      this.items = this.items.filter(i => i.id !== id);
      this.selected.delete(id);
    },

    async exportCsv() {
      const ids = Array.from(this.selected);
      const res = await axios.post(`${API}/export/csv`, { ids }, { responseType: 'blob' });
      const url = URL.createObjectURL(res.data);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'contacts.csv';
      a.click();
      URL.revokeObjectURL(url);
    },

    async fetchViaCep(zip) {
      const clean = zip.replace(/\D/g, '');
      if (clean.length !== 8) return null;
      const { data } = await axios.get(`https://viacep.com.br/ws/${clean}/json/`);
      if (data.erro) return null;
      return {
        zip_code: `${data.cep}`,
        state: data.uf,
        city: data.localidade,
        district: data.bairro,
        address: data.logradouro,
      };
    },
  },
});
