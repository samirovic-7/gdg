<script setup>
import {
  lengthValidator,
  requiredValidator,
  integerValidator,
  betweenValidator,
} from '@validators'
</script>

<template>
<div style="float: left;width: 14%;display: flex;justify-content: space-between">
      <VBtn
        class="btn"
        @click="exportExecl"
      >

        {{ $t('export') }}
      </VBtn>
      <VBtn
        class="btn"
        @click="Downpdf"
      >

        {{ $t('PDF') }}
      </VBtn>
    </div>

    <br>
    <br>
    <br>

    <VTable style="table-layout: fixed">
      <thead>
      <tr>
        <th class="text-left">
          {{ $t('no.') }}
        </th>
        <th class="text-left">
          {{ $t('feature name') }}
        </th>
        <th class="text-left">
          {{ $t('consumable') }}
        </th>
        <th class="text-left">
          {{ $t('periodicity') }}
        </th>
        <th class="text-left">
          {{ $t('periodicity_type') }}
        </th>
        <th class="text-left">
          {{ $t('post paid') }}
        </th>
        <th class="text-left">
          {{ $t('quata') }}
        </th>
        <th class="text-left">
          {{ $t('quata') }}
        </th>
        <th class="text-left">
          {{ $t('email') }}
        </th>
        <th class="text-left">
          {{ $t('quata') }}
        </th>
        <th class="text-left">
          {{ $t('update') }}
        </th>
      </tr>
      </thead>


      <tbody>
      <tr
        v-for="(item , index) in Settings"
        :key="item.id"
        style="text-align: left"
      >
        <td> {{ ++index }}</td>

        <td>{{ item.name }}</td>
        <td>{{ item.type }}</td>
        <td>{{ item.cr_no }}</td>
        <td>{{ item.phone }}</td>
        <td>{{ item.mobile }}</td>
        <td>{{ item.email }}</td>
        <td>{{ item.city }}</td>
        <td>{{ item.address }}</td>
        <td>{{ item.vat_no }}</td>
        <td>
          <VBtn
            color="primary"
          >
            <VRow>
              <VDialog
                v-model="item.dialog3"
                width="1024"
              >
                <template #activator="{ props }">
                  <VBtn
                    v-bind="props"
                    @click="Updates(item)"
                  >
                    <VIcon icon="mdi-file-edit-outline" />
                  </VBtn>
                </template>
                <VCard>
                  <VCardTitle>
                    <span class="text-h5">Update Feature data</span>
                  </VCardTitle>
                  <VCardText>
                    <VContainer>
                      <VRow>
                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="name_edit"
                            label="Name edit"
                          />
                        </VCol>
       <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="name_loc_edit"
                            label="Name loc edit"
                          />
                        </VCol>


                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="type_edit"
                            label="type edit"
                          />
                        </VCol>



                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="email_edit"
                            label="email edit"
                          />
                        </VCol>


                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="phone_edit"
                            label="phone edit"
                          />
                        </VCol>


                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="mobile_edit"
                            label="mobil edit"
                          />
                        </VCol>


                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="cr_no_edit"
                            label="Cr No edit"
                          />
                        </VCol>



                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="city_edit"
                            label="city edit"
                          />
                        </VCol>



                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="address_edit"
                            label="address edit"
                          />
                        </VCol>


                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="vat_no_edit"
                            label="Vat No edit"
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
                      @click="dialog3 = false"
                    >
                      Close
                    </VBtn>
                    <VBtn
                      color="blue-darken-1"
                      variant="text"
                      @click="updateUser"
                    >
                      Update
                    </VBtn>
                  </VCardActions>
                </VCard>
              </VDialog>
            </VRow>
          </VBtn>
        </td>
      </tr>
      </tbody>

     </VTable>
 </template>

<script>
import axios from "axios"

export default {
  name: "SettingTable",

  // eslint-disable-next-line vue/component-api-style
  data(){
    return {

      search:'',
      dialog: false,
      dialog3: false,
      Settings:[],
      featureid:'',
      feature_id:'',



      name_edit:'',
      name_loc_edit:'',
      type_edit:'',
      email_edit:'',
      phone_edit:'',
      cr_no_edit:'',
      city_edit:'',
      address_edit:'',
      vat_no_edit:'',
      mobile_edit:'',



    }
  },

  // eslint-disable-next-line vue/component-api-style
  mounted() {
    this.getAllSetting()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
    UpdateAlert() {
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
        icon: 'info',
        title: 'updateed is successfully',
        color: 'mediumpurple',
        timer: 5000,
      })
    },


    getAllSetting(){
      axios
        .get('api/settings')
        .then(response => (this.Settings = response.data))
    },







    async  Updates(Getdata){

      this.featureid = Getdata


      this.name_edit= Getdata.name,
      this.name_loc_edit= Getdata.name_loc,
      this.type_edit= Getdata.type,
      this.email_edit= Getdata.email,
      this.phone_edit= Getdata.phone,
      this.mobile_edit= Getdata.mobile,
      this.address_edit= Getdata.address,
      this.city_edit= Getdata.city,
      this.cr_no_edit= Getdata.cr_no,
      this.vat_no_edit= Getdata.vat_no

    },


    async updateUser() {


      try {
        const user = await axios.put(
          `api/settings/${this.featureid.feature_id}`,
          {
            name: this.name_edit,
            name_loc: this.name_loc_edit,
            type: this.type_edit,
            cr_no: this.cr_no_edit,
            phone: this.phone_edit,
            mobile: this.mobile_edit,
            email: this.email_edit,
            city: this.city_edit,
            address: this.address_edit,
            vat_no: this.vat_no_edit,

          },
        )

        console.log(user)

        this.getAllPaginate()
        this.dialog3 = false
        this.UpdateAlert()
      } catch(e) {
        console.log(e)
      }

    },

  },

}
</script>

<style>
/* width */
::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey;
  border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: mediumpurple;
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: rgba(147, 112, 219, .6);  ;
}
</style>
