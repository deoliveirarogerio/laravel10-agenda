import { createRouter, createWebHistory } from 'vue-router';
import AdminLayout from '../views/admin/AdminLayout.vue';
import ContactList from '../views/admin/ContactList.vue';
import ContactForm from '../views/admin/ContactForm.vue';
import ListContact from '../views/ListContact.vue';

const routes = [
  { path: '/', name: 'contacts', component: ListContact },
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      { path: 'contacts', name: 'admin.contacts', component: ContactList },
      { path: 'contacts/new', name: 'admin.contacts.new', component: ContactForm },
      { path: 'contacts/edit/:id', name: 'admin.contacts.edit', component: ContactForm, props: true },
    ],
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
