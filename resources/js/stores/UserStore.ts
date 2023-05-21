import { RoleStore } from './RoleStore';
import { defineStore, storeToRefs } from 'pinia'
import { ref } from 'vue'
import { RoleCreate, RoleUpdate } from 'resources/ts/interfaces/Role/Role.dto'

export const UserStore = defineStore('User', () => {
  const roleStore = RoleStore()
  const { roles } = storeToRefs(roleStore)
  const { getRoles } = roleStore

  const form = ref<RoleCreate | RoleUpdate>({
    name: '',
    guard_name: '',
    permissions: [],
  })

  const resetForm = () => {
    form.value = {
        name: '',
        guard_name: '',
        permissions: [],
    }
  }
  return {
    roles,
    getRoles,
    form,
    resetForm
  }
})
