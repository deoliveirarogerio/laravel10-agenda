import { createRouter, createWebHistory } from 'vue-router';
import AdminLayout from '../views/admin/AdminLayout.vue';
import ContactList from '../views/admin/ContactList.vue'
import ContactForm from '../views/admin/ContactForm.vue'
import LoginView from '../views/admin/LoginView.vue'

const routes = [
  {
    path: '/admin/login',
    name: 'admin.login',
    component: LoginView,
    meta: { public: true, title: 'Login' },
  },

  {
    path: '/admin',
    component: AdminLayout,
    children: [
      {
        path: 'contacts',
        name: 'admin.contacts',
        component: ContactList,
        meta: { title: 'Contatos' },
      },
      {
        path: 'contacts/new',
        name: 'admin.contacts.new',
        component: ContactForm,
        meta: { title: 'Novo Contato' },
      },
      {
        path: 'contacts/:id',
        name: 'admin.contacts.edit',
        component: ContactForm,
        meta: { title: 'Editar Contato' },
        props: true,
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
