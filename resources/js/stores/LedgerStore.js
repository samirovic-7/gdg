import { defineStore } from 'pinia'
import axios from 'axios'


export const useLedgerStore = defineStore('ledger', {
  state: () => ({
    ledgerCats: [],
    ledgers: [],
  }),
  actions: {
    getledgerCats() {
      axios.get('api/ledger-cats')
        .then(res => {
          this.ledgerCats = res.data
        })
        .catch(err => {
          console.log(err.message)
        })
    },

    addLedger(ledger) {
      axios.post('api/ledger', ledger)
        .then(res => {
          this.getLedgers()
        })
        .catch(err => {
          console.log(err.message)
        })
    },

    getLedgers() {
      axios.get('api/ledger')
        .then(res => {
          this.ledgers = res.data
        })
        .catch(err => {
          console.log(err.message)
        })
    },

    editLedger(ledger, id) {
      axios.put(`api/ledger/${id}`, ledger)
        .then(res => {
          this.getLedgers()
        })
        .catch(err => {
          console.log(err.message)
        })
    },

    deleteLedger(id) {
      axios.delete(`api/ledger/${id}`)
        .then(res => {
          this.getLedgers()
        })
        .catch(err => {
          console.log(err.message)
        })
    },
  },
})
