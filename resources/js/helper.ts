// @ts-ignore

import { defineStore } from 'pinia'
import { ref, reactive } from 'vue'
import axios, { AxiosRequestConfig, AxiosResponse, Method } from 'axios'
import { TYPE, useToast } from 'vue-toastification'
import { ToastOptions } from 'vue-toastification/dist/types/types'
import { useI18n } from 'vue-i18n'

export const helperStore = defineStore('helper', () => {
  const { t } = useI18n()
  const openHamburgerMenu = ref(false)
  const loading = ref()
  const items = ref()
  const item = ref()
  const url = ref('')
  const openModalCrud = ref<boolean>(false)
  const params = ref({})
  const perPage = [5, 10, 15]
  const pagination = reactive({
    perPage: 15,
    currentPage: 1,
    to: 1,
    total: 0,
  })
  const paginated = ref({
    currentPage: 1,
    perPage: 6,
  })
  const clickIn = ref<'Show' | 'Edit' | 'Create' | ''>('')
  const toast = useToast()

  const http = (
    url: string,
    method: Method = 'get',
    options: AxiosRequestConfig = {},
    notification = '',
  ) => {
    return new Promise(async (resolve, reject) => {
      try {
        loading.value = true
        let config: AxiosRequestConfig = {
          url,
          method,
          ...options,
        }

        if (isAutenticated()) {
          config.headers = {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          }
        }
        let response: AxiosResponse = await axios(config)
        if (notification) {
          showNotify(notification)
        }
        resolve(response)
      } catch (error: AxiosResponse | any) {
        let messages: string[] | string = error.response.data.errors
          ? error.response.data.errors
          : error.response.data.message

        if (typeof messages === 'string') {
          showNotify(messages, { type: TYPE.ERROR })
        } else {
          getErrors(error.response.data.errors)
        }
        if (error.response && error.response.status === 401) {
          localStorage.removeItem('token')
          localStorage.removeItem('user')
        }
        loading.value = false
        reject(error)
      } finally {
        loading.value = false
      }
    })
  }

  const getErrors = (errors: any) => {
    let error: string[] = []
    let op: ToastOptions = {
      type: TYPE.ERROR,
    }
    if (errors) {
      for (let err in errors) {
        error.push(errors[err][0])
      }
    }
    error.forEach((er) => showNotify(er, op))
  }

  const showNotify = (
    msg: string,
    options: ToastOptions = { type: TYPE.SUCCESS },
  ) => {
    toast(msg, {
      ...options,
    }) // ToastOptions
  }

  const index = async (params: any = {}) => {
    items.value = []
    let response: any = await http(url.value, 'get', {
      params: {
        ...params,
        perPage: pagination.perPage,
        currentPage: pagination.currentPage,
        paginated: 1,
        ...params.value,
      },
    })
    items.value = response.data.data
    pagination.to = response.data.to
    pagination.total = response.data.last_page
  }

  const show = (id: any) => {
    return new Promise(async (resolve, reject) => {
      try {
        let response = await http(url.value + '/' + id, 'get')

        resolve(response)
      } catch (err) {
        reject(err)
      }
    })
  }

  const put = (id: any, data: any, notify= true) => {
    return new Promise(async (resolve, reject) => {
      try {
        const message = notify ? t('commons.update-success') : ''
        let response = await http(url.value + '/' + id, 'put', { data },message)

        resolve(response)
      } catch (err) {
        reject(err)
      }
    })
  }

  const create = (data: any, notify= true) => {
    return new Promise(async (resolve, reject) => {
      try {
        const message = notify ? t('commons.create-success') : ''
        let response = await http(
          url.value,
          'post',
          { data },
          message,
        )

        resolve(response)
      } catch (err) {
        reject(err)
      }
    })
  }

  const deleted = (id: any) => {
    return new Promise(async (resolve, reject) => {
      try {
        let response
        if (isDeleted(id)) {
          response = await http(url.value + id + '/restore', 'put')
        } else {
          response = await http(url.value + '/' + id, 'delete')
        }
        resolve(response)
      } catch (err) {
        reject(err)
      }
    })
  }

  const isDeleted = (id: any) => {
    const element = items.value.find((item: any) => item.id === id)

    return element.isDeleted ?? false
  }

  return {
    openHamburgerMenu,
    pagination,
    items,
    item,
    http,
    paginated,
    showNotify,
    getErrors,
    index,
    show,
    put,
    create,
    deleted,
    url,
    perPage,
    isDeleted,
    loading,
    clickIn,
    openModalCrud,
    params,
  }
})
export const isAutenticated = () => {
  return localStorage.getItem('token') || false
}
