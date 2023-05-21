import { defineStore, storeToRefs } from 'pinia'
import { PermissionStore } from './PermissionStore'
import { ref } from 'vue'
import { RoleCreate, RoleUpdate } from 'resources/ts/interfaces/Role/Role.dto'

export const RoleStore = defineStore('role', () => {
  const permissionsStore = PermissionStore()
  const { permissions } = storeToRefs(permissionsStore)
  const { getPermissions } = permissionsStore

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
    permissions,
    getPermissions,
    form,
    resetForm
  }
})
