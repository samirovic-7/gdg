import router from "@/router"
import { defineStore } from 'pinia'
import axios from 'axios'

export const useTaxesStore = defineStore('taxes', {
  state: () => ({
    taxes: [],
  }),
  actions: {
    getTaxes() {
      axios.get('api/tax')
        .then(res => {
          this.taxes = res.data
        })
        .catch(err => {
          console.log(err.message)
        })
    },

    addTax(tax) {
      axios.post('api/tax', tax)
        .then(res => {
          this.getTaxes()
        })
        .catch(err => {
          console.log(err.message)
        })
    },

    editTax(tax, id) {
      axios.put(`api/tax/${id}`, tax)
        .then(res => {
          this.getTaxes()
        })
        .catch(err => {
          console.log(err.message)
        })
    },

    deleteTax(id) {
      axios.delete(`api/tax/${id}`)
        .then(res => {
          this.getTaxes()
        })
        .catch(err => {
          console.log(err.message)
        })
    },
  },
})
