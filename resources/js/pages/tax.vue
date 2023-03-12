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
              Add Tax
            </VBtn>
          </template>

          <VCard>
            <VCardTitle>
              <span class="text-h5">{{ editFlag?'Edit':'Add New' }} Tax</span>
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
                      v-model="tax_name"
                      label="Tax Name"
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
                      v-model="tax_name_loc"
                      label="Tax Name Loc"
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
                    <VTextField
                      v-model="tax_percent"
                      label="Tax Percentage %"
                      persistent-placeholder
                      type="number"
                      :disabled="disablePercentage"
                      min="0"
                      max="100"
                      max-length="3"
                      @input="toggleAmount"
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="tax_amount"
                      label="Tax Amount"
                      persistent-placeholder
                      type="number"
                      :disabled="disableAmount"
                      min="0"
                      @input="togglePercent"
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
                @click="submitTax"
              >
                Submit
              </VBtn>
            </VCardActions>
          </VCard>
        </VDialog>
      </div>
    </div>

    <div>
      <VBtn
        class="btn mx-4"
      >
        export
      </VBtn>
      <VBtn
        class="btn mx-4"
      >
        PDF
      </VBtn>
    </div>
  </div>

  <VTable>
    <thead>
      <tr>
        <th v-if="$i18n.locale==='en'">
          Name
        </th>
        <th v-else>
          {{ $t('name') }} ({{ $i18n.locale }})
        </th>
        <th>Percentage</th>
        <th>Amount</th>
        <th>Delete</th>
        <th>Update</th>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="tax in filteredTexes"
        :key="tax.id"
      >
        <td v-if="$i18n.locale==='en'">
          {{ tax.name }}
        </td>
        <td v-else>
          {{ tax.name_loc }}
        </td>
        <td v-if="tax.per">
          {{ tax.per }} %
        </td>
        <td v-else>
          -
        </td>
        <td v-if="tax.amount">
          {{ tax.amount }}
        </td>
        <td v-else>
          -
        </td>
        <td>
          <VBtn @click="del(tax.id)">
            <VIcon icon="mdi-delete" />
          </VBtn>
        </td>
        <td>
          <VBtn @click="update(tax)">
            <VIcon icon="mdi-file-edit-outline" />
          </VBtn>
        </td>
      </tr>
    </tbody>
  </VTable>
</template>

<script>
import { useTaxesStore } from '../stores/TaxesStore'
import { mapStores, mapActions } from 'pinia'

export default {
  name: "tax",
  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      search: '',
      dialog: false,
      tax_name: '',
      tax_name_loc: '',
      tax_percent: '',
      tax_amount: '',
      disablePercentage: false,
      disableAmount: false,
      editFlag: false,
      tax_id: '',
    }
  },

  // eslint-disable-next-line vue/component-api-style
  computed: {
    ...mapStores(useTaxesStore),

    taxes() {
      return this.taxesStore.taxes 
    },


    filteredTexes() {
      return this.taxes.filter(tax => {
        return tax.name.includes(this.search) ||
                tax.name_loc.includes(this.search) 

        // tax.per.includes(Number(this.search)) ||
        // tax.amount.includes(this.search)
      })
    },
  },

  methods: {
    ...mapActions(useTaxesStore,['getTaxes', 'addTax', 'editTax', 'deleteTax']),

    toggleAmount() {
      (this.tax_percent||this.tax_percent>0)?this.disableAmount=true:this.disableAmount=false
      this.tax_percent > 100 ? this.tax_percent = 100 : ''
      this.tax_percent < 0 ? this.tax_percent = 0 : ''
    },

    togglePercent() {
      (this.tax_amount||this.tax_amount>0)?this.disablePercentage=true:this.disablePercentage=false
      this.tax_amount < 0 ? this.tax_amount = 0 : ''
    },

    clearForm() {
      this.tax_name = ''
      this.tax_name_loc = ''
      this.tax_percent = ''
      this.tax_amount = ''
      this.disableAmount=false
      this.disablePercentage=false
    },

    submitTax() {
      if(!this.editFlag) {
        this.addTax({
          name: this.tax_name,
          name_loc: this.tax_name_loc,
          per: this.tax_percent==''?null:this.tax_percent,
          amount: this.tax_amount==''?null:this.tax_amount,
          formula: "a + b",
          extra: "extra information",
          accept_per: true,
        })
        this.dialog = false
        this.clearForm()
      } else {
        this.editTax({
          name: this.tax_name,
          name_loc: this.tax_name_loc,
          per: this.tax_percent,
          amount: this.tax_amount,
          formula: "a + b",
          extra: "extra information",
          accept_per: true,
        }, this.tax_id)
        this.clearForm()
      }
    },

    update(tax) {
      this.editFlag = true
      this.dialog = true
      this.tax_name = tax.name
      this.tax_name_loc = tax.name_loc
      this.tax_percent = tax.per
      this.tax_amount = tax.amount
      this.tax_percent?this.disableAmount=true:this.disableAmount=false
      this.tax_amount?this.disablePercentage=true:this.disablePercentage=false
      this.tax_id = tax.id
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
          this.deleteTax(id)

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

  created() {
    this.editFlag = false
    this.getTaxes()
  },
}
</script>

<style scoped>
.filter {
    display: flex;
}
</style>
