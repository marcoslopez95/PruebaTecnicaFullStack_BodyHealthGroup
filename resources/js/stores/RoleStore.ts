import { defineStore, storeToRefs } from 'pinia'
import { PermissionStore } from './PermissionStore'
import { ref } from 'vue'
import { RoleCreate, RoleUpdate } from 'resources/ts/interfaces/Role/Role.dto'
import { Role } from 'resources/ts/interfaces/Role/Role.model'
import { helperStore } from '@/helper'

export const RoleStore = defineStore('Role', () => {
    const helper = helperStore()
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

  const roles = ref<Role[]>([])
  const getRoles = () => {
    helper.http('/api/v1/admin/security/permissions').then((res: any) => {
      permissions.value = res.data.data as Role[]
    })
  }
  return {
    permissions,
    getPermissions,
    form,
    resetForm,
    roles,
    getRoles
  }
})
