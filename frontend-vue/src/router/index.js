import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import IndexView from '../views/IndexView.vue'
import ArrayInput from '../views/ArrayInput.vue'
import CustomerCreate from '../views/Customers/Create.vue'
import CustomerEdit from '../views/Customers/Edit.vue'
import CustomerDetail from '../views/Customers/Detail.vue'
import AddressCreate from '../views/Addresses/CreateAddress.vue'
import AddressEdit from '../views/Addresses/EditAddress.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'homeView',
      component: HomeView,
    },
    {
      path: '/customers',
      name: 'indexView',
      component: IndexView
    },
    {
      path: '/customers/create',
      name: 'customerCreate',
      component: CustomerCreate
    },
    {
      path: '/customers/:id/edit',
      name: 'customerEdit',
      component: CustomerEdit
    },
    {
      path: '/customers/:id',
      name: 'customerDetail',
      component: CustomerDetail
    },
    {
      path: '/customers/:customerId/addresses/create',
      name: 'addressCreate',
      component: AddressCreate
    },
    {
      path: '/customers/:customerId/addresses/:addressId/edit',
      name: 'addressEdit',
      component: AddressEdit
    },
    {
      path: '/arrayinput',
      name: 'arrayInput',
      component: ArrayInput
    },
    
  ]
})

export default router
