import { RoleStore } from './RoleStore'
import { defineStore, storeToRefs } from 'pinia'
import { ref } from 'vue'
import { RoleCreate, RoleUpdate } from 'resources/ts/interfaces/Role/Role.dto'
import { UserCreate, UserUpdate } from 'resources/ts/interfaces/User/User.dto'

export const UserStore = defineStore('User', () => {
  const roleStore = RoleStore()
  const { roles } = storeToRefs(roleStore)
  const { getRoles } = roleStore

  const form = ref<UserCreate | UserUpdate>({
    name: '',
    email: '',
    role_id: '',
    password: '',
    password_confirmation: '',
  })

  const resetForm = () => {
    form.value = {
      name: '',
      email: '',
      role_id: '',
      password: '',
      password_confirmation: '',
    }
  }
  return {
    roles,
    getRoles,
    form,
    resetForm,
  }
})
