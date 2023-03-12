<template>
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div class="filter w-50">
      <div
        style="flex-basis: 20%;"
        class="ml-4"
      >
        <VSelect
          label="row"
          :items="['10', '20', '30', '40']"
          variant="solo"
        />
      </div>

      <div
        style="flex-basis: 50%;"
        class="ml-4"
      >
        <VTextField
          v-model="search"
          type="text"
          label="Search"
        />
      </div>

      <div>
        <VDialog
          v-model="dialog"
          width="1024"
        >
          <template #activator="{ props }">
            <VBtn
              class="ml-4"
              v-bind="props"
              @click="clearForm"
            >
              Add Ledger
            </VBtn>
          </template>

          <VCard>
            <VCardTitle>
              <span class="text-h5">{{ editFlag?'Edit':'Add New' }} Ledger</span>
            </VCardTitle>

            <VCardText>
              <VContainer>
                <VRow class="mb-4">
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="ledger_name"
                      label="Ledger Name"
                      persistent-placeholder
                      type="text"
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="ledger_name_loc"
                      label="Ledger Name Loc"
                      persistent-placeholder
                      type="text"
                    />
                  </VCol>
                </VRow>

                <VRow class="mb-4">
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VSelect
                      v-model="ledger_type"
                      label="Ledger Type"
                      :items="['Credit', 'Debit']"
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VSelect
                      v-model="ledger_category"
                      label="Ledger Category"
                      :items="ledgerCats"
                      item-title="name"
                      item-value="id"
                      persistent-placeholder
                    />
                  </VCol>
                </VRow>

                <VRow class="mb-4">
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VSelect
                      v-model="include_tax"
                      :items="taxes"
                      label="Included Taxes"
                      multiple
                      hint="Pick your included taxes"
                      persistent-hint
                      persistent-placeholder
                      item-title="name"
                      item-value="id"
                      chips
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VSelect
                      v-model="exclude_tax"
                      :items="taxes"
                      label="Excluded Taxes"
                      multiple
                      hint="Pick your excluded taxes"
                      persistent-hint
                      persistent-placeholder
                      item-title="name"
                      item-value="id"
                      chips
                    />
                  </VCol>
                </VRow>
              </VContainer>
            </VCardText>

            <VCardActions>
              <VSpacer />

              <VBtn
                color="blue-darken-1"
                variant="text"
                @click="dialog = false"
              >
                Close
              </VBtn>

              <VBtn
                color="blue-darken-1"
                variant="text"
                @click="submitLedger"
              >
                Submit
              </VBtn>
            </VCardActions>
          </VCard>
        </VDialog>
      </div>
    </div>
  </div>

  <VTable>
    <thead>
      <tr>
        <!--        <th v-if="$i18n.locale==='en'"> -->
        <!--          Name -->
        <!--        </th> -->
        <!--        <th v-else> -->
        <!--          {{ $t('name') }} ({{ $i18n.locale }}) -->
        <!--        </th> -->
        <th>Type</th>
        <th>Category</th>
        <th>Included Taxes</th>
        <th>Excluded Taxes</th>
        <th>Delete</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(ledger,index) in filteredLedgers"
        :key="Ledger.id"
      >
        <!--        <td v-if="$i18n.locale==='en'"> -->
        <!--          {{ ledger.name }} -->
        <!--        </td> -->
        <!--        <td v-else> -->
        <!--          {{ ledger.name_loc }} -->
        <!--        </td> -->
        <td v-if="Ledger.type">
          {{ Ledger.type }}
        </td>
        <td v-else>
          -
        </td>
        <td v-if="Ledger.ledger_cat_id">
          {{ Ledger.ledger_cat_id }}
        </td>
        <td v-else>
          -
        </td>
        <td v-if="Ledger.inctaxes">
          <span
            v-for="inctax in Ledger.inctaxes"
            :key="inctax.id"
          >
            <VChip class="ma-2">
              {{ inctax.name }}
            </VChip>
            <br v-if="inctax.id%3===0">
          </span>
        </td>
        <td v-else>
          -
        </td>
        <td v-if="Ledger.taxes">
          <span
            v-for="extax in Ledger.taxes"
            :key="extax.id"
          >
            <VChip class="ma-2">
              {{ extax.name }}
            </VChip>
            <br v-if="extax.id%3===1">
          </span>
        </td>
        <td v-else>
          -
        </td>
        <td>
          <VBtn @click="del(Ledger.id)">
            <VIcon icon="mdi-delete" />
          </VBtn>
        </td>
        <td>
          <VBtn @click="update(Ledger)">
            <VIcon icon="mdi-file-edit-outline" />
          </VBtn>
        </td>
      </tr>
    </tbody>
  </VTable>
</template>

<script>
import { useTaxesStore } from '@/stores/TaxesStore'
import { useLedgerStore } from '@/stores/LedgerStore'
import { mapStores, mapActions } from 'pinia'

export default {
  name: "Ledger",
  // eslint-disable-next-line vue/component-api-style
  data() {
    return {
      search: '',
      dialog: false,
      editFlag: false,
      ledger_name: '',
      ledger_name_loc: '',
      ledger_type: '',
      include_tax: [],
      exclude_tax: [],
      ledger_category: '',
      ledger_id: '',
      included_tax_id_forEdit: [],
      excluded_tax_id_forEdit: [],
    }
  },

  // eslint-disable-next-line vue/component-api-style
  computed: {
    ...mapStores(useTaxesStore, useLedgerStore),

    taxes() {
      return this.taxesStore.taxes
    },

    ledgerCats() {
      return this.ledgerStore.ledgerCats
    },

    ledgers() {
      return this.ledgerStore.ledgers
    },

    filteredLedgers() {
      return this.ledgers.filter(ledger => {
        return Ledger.name.toLowerCase().includes(this.search) ||
                Ledger.name_loc.toLowerCase().includes(this.search) ||
                Ledger.type.toLowerCase().includes(this.search) ||
                Ledger.inctaxes.some(inc => inc.name.toLowerCase().includes(this.search)) ||
                Ledger.taxes.some(ex => ex.name.toLowerCase().includes(this.search))
      })
    },
  },
  // eslint-disable-next-line vue/component-api-style
  created() {
    this.editFlag = false
    this.getTaxes()
    this.getledgerCats()
    this.getLedgers()
  },
  // eslint-disable-next-line vue/component-api-style
  methods: {
    ...mapActions(useTaxesStore, ['getTaxes']),
    ...mapActions(useLedgerStore, ['getledgerCats', 'addLedger', 'getLedgers', 'editLedger', 'deleteLedger']),

    clearForm() {
      this.ledger_name = ''
      this.ledger_name_loc = ''
      this.ledger_type = ''
      this.include_tax = []
      this.exclude_tax = []
      this.ledger_category = ''
    },

    submitLedger() {
      if (!this.editFlag) {
        this.addLedger({
          code: '1',
          name: this.ledger_name,
          name_loc: this.ledger_name_loc,
          type: this.ledger_type,
          inctaxes: this.include_tax,
          taxes: this.exclude_tax,
          ledger_cat_id: this.ledger_category,
        })
        this.dialog = false
        this.clearForm()
      } else {
        if (typeof this.include_tax[0] == 'object' && this.include_tax) {
          this.included_tax_id_forEdit = this.include_tax.map(tax => tax.id)
        } else {
          this.included_tax_id_forEdit = this.include_tax
        }

        if (typeof this.exclude_tax[0] == 'object' && this.exclude_tax) {
          this.excluded_tax_id_forEdit = this.exclude_tax.map(tax => tax.id)
        } else {
          this.excluded_tax_id_forEdit = this.exclude_tax
        }

        this.editLedger({
          code: '1',
          name: this.ledger_name,
          name_loc: this.ledger_name_loc,
          type: this.ledger_type,
          inctaxes: this.included_tax_id_forEdit,
          taxes: this.excluded_tax_id_forEdit,
          ledger_cat_id: this.ledger_category,
        }, this.ledger_id)
        this.dialog = false
        this.clearForm()
      }
    },

    update(ledger) {
      this.editFlag = true
      this.dialog = true
      this.ledger_id = Ledger.id
      this.ledger_name = Ledger.name
      this.ledger_name_loc = Ledger.name_loc
      this.ledger_type = Ledger.type
      this.include_tax = Ledger.inctaxes
      this.exclude_tax = Ledger.taxes
      this.ledger_category = Ledger.ledger_cat_id
    },

    del(id) {
      this.$swal.fire({
        icon: 'error',
        title: 'Do you want to Delete',
        showDenyButton: true,
        showCancelButton: true,
        showConfirmButton:false,
        denyButtonText: `Delete`,
      }).then(result => {

        if (result.isDenied) {
          this.deleteLedger(id)

          const Toast = this.$swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: toast => {
              toast.addEventListener('mouseenter', this.$swal.stopTimer)
              toast.addEventListener('mouseleave', this.$swal.resumeTimer)
            },
          })

          Toast.fire({
            icon: 'success',
            title: `Data ${this.room_name_en} Deleted successfully`,
            color: 'red',
            timer: 10000,
          })
        }
      })
    },
  },


}
</script>

<style scoped>
.filter {
    display: flex;
}
</style>
