<script setup>
import {
  lengthValidator,
  requiredValidator,
  integerValidator,
  betweenValidator,
} from '@validators'
</script>

<template>
  <div style="margin-top: 5%">
    <div style="float: right;width: 45%;display: flex;justify-content: space-between;">
      <VRow justify="">
        <div style="width: 65%;display: flex;justify-content: space-between">
          <VSelect
            v-model="pageSize"
            :label="$t('row')"
            :items="pageSizes"
            :value="pageSize"
            variant="solo"
            style="width: 18%;"
          />
          <VSpacer />

          <VTextField
            v-model="search"
            type="text"

            label="Search"
            style="width: 70%;"
          />
        </div>
        <VSpacer />
        <VDialog
          v-model="dialog"
          width="1024"
        >
          <template #activator="{ props }">
            <VBtn
              v-bind="props"
            >
              {{ $t('Add plan') }}
            </VBtn>
          </template>
          <VCard>
            <VCardTitle>
              <span class="text-h5"> {{ $t('Add New Plan') }}</span>
            </VCardTitle>
            <VCardText>
              <VContainer>
                <VRow>
                  <VCol
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <VTextField
                      v-model="plan_name"
                      label="plan Name"
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
                      v-model="periodicity_of_plan"
                      label="periodicity_of_plan"
                      type="number"
                      persistent-placeholder
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    md="6"
                    sm="6"
                  >
                    <VSelect
                      v-model="periodicity_type"
                      :items="periodicity_types"
                      item-title="periodicity type"
                      item-value="plan_id"
                      persistent-placeholder
                      label="periodicity type"
                    />
                  </VCol>


                  <VCheckbox
                    v-for="(item , index) in features"
                    :key="item.id"
                    v-model="features_type"
                    :label="item.feature_name"
                    :value="item.feature_id"
                    style="width:150px; display: flex ;justify-content: space-around"
                    @input="saveFeature(item.feature_id)"
                  />
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
                @click="Add"
              >
                Submit
              </VBtn>
            </VCardActions>
          </VCard>
        </VDialog>
      </VRow>
    </div>


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
            {{ $t('Num') }}
          </th>
          <th class="text-left">
            {{ $t('plan name') }}
          </th>
          <th class="text-left">
            {{ $t('periodicity of plan') }}
          </th>
          <th class="text-left">
            {{ $t('periodicity type') }}
          </th>
          <th class="text-left">
            {{ $t('feature name') }}
          </th>
          <th class="text-left">
            {{ $t('Delete') }}
          </th>
          <th class="text-left">
            {{ $t('Update') }}
          </th>
        </tr>
      </thead>


      <tbody>
        <tr
          v-for="(item , index) in filterData"
          :key="item.id"
          style="text-align: left"
        >
          <td> {{ ++index }}</td>

          <td>{{ item.plan_name }}</td>
          <td>{{ item.periodicity_of_plan }}</td>
          <td>{{ item.periodicity_type }}</td>
          <br>

          <td
            v-for="(element , index) in item.features"
            :key="element.id"
            style="display: block;"
          >
            <VChip
              class="ma-2"
              append-icon="mdi-star"
              style="color: gold;"
            >
              <span style="color: black">{{ element.name }}</span>
            </VChip>
          </td>





          <td style="table-layout: fixed ">
            <VBtn
              color="primary"
              @click="Delete(item.plan_id)"
            >
              <VIcon icon="mdi-delete" />
            </VBtn>
          </td>
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
                      <span class="text-h5">Update User Profile</span>
                    </VCardTitle>
                    <VCardText>
                      <VContainer>
                        <VRow>
                          <VCol
                            cols="12"
                            sm="12"
                            md="12"
                          >
                            <VTextField
                              v-model="plan_name_edit"
                              label="plan Name"
                            />
                          </VCol>

                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="periodicity_of_plan_edit"
                              label="periodicity of plan"
                              type="number"
                            />
                          </VCol>

                          <VCol
                            cols="12"
                            md="6"
                            sm="6"
                          >
                            <VSelect
                              v-model="periodicity_type_edit"
                              :items="periodicity_types"
                              item-title="periodicity type"
                              item-value="plan_id"
                              persistent-placeholder
                              label="periodicity type"
                            />
                          </VCol>



                          <VCheckbox
                            v-for="(item , index) in features"
                            :key="item.id"
                            v-model="features_type_edit"
                            :value="item.feature_id"
                            style="width:150px; display: flex ;justify-content: space-around"
                            :label="item.feature_name"
                            @input="saveFeature(item.feature_id)"
                          />
                        </VRow>
                      </VContainer>
                    </VCardText>
                    <VCardActions>
                      <VSpacer />
                      <VBtn
                        color="blue-darken-1"
                        variant="text"
                        @click="item.dialog3= false"
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
      <br>
      <caption>{{ $t('List Of Data') }}( 1 )</caption>
    </VTable>
    <div style="float: right">
      <VPagination
        v-if="pageInfo"
        v-model="pageInfo.current_page"
        :length="Math.ceil(pageInfo.total / pageSize)"
        total-visible="7"
        :size="43"
        :next="pageInfo.next_page_url"
        :per-page="pageInfo.per_page"
        @click="nextPage(pageInfo.per_page, pageInfo.current_page)"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios"
import feature from "@/pages/feature.vue"

// import xlsx from "xlsx/dist/xlsx.full.min"
// import pdfMake from "pdfmake/build/pdfmake"
// import pdfFonts from "pdfmake/build/vfs_fonts"
// import router from "@/router"
//
// pdfMake.vfs = pdfFonts.pdfMake.vfs

export default {
  name: "PlanTable",

  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      search:'',
      dialog: false,
      dialog3: false,
      plans:[],
      features:[],
      planId:'',
      features_type: [],
      features_type_selected_ids: [],

      plan_id: '',

      grace_days: '',
      plan_name: '',
      periodicity_of_plan: '',

      periodicity_type: '',
      periodicity_types:['Day','Week','Month','Year'],


      plan_name_edit: '',
      periodicity_of_plan_edit: '',
      periodicity_type_edit: '',
      features_type_edit:'',



      count:0,
      perPage:10,
      pagi:[],
      page:2,
      pageInfo:null,
      totalPages: 4,
      pageSize: 5,
      pageSizes: [5, 10, 15,20,25,30],

    }
  },

  // eslint-disable-next-line vue/component-api-style
  computed:{
    filterData(){

      return  this.pagi.filter(user =>user.plan_name.includes(this.search))
    },
  },

  // eslint-disable-next-line vue/component-api-style
  watch: {
    pageSize() {
      this.getAllPaginate()
    },
  },

  // eslint-disable-next-line vue/component-api-style
  mounted() {
    this.getAllplans()
    this.getFeature()
    this.getAllPaginate()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
    async getAllPaginate(){
      console.log(this.pageSize)
      axios
        .get(`api/planPagination/${this.pageSize}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
            this.pageInfo = response.data.pagination
            )
            console.log(this.pagi)
            console.log(this.pageInfo)
          }
        })

    },

    nextPage(page, query) {
      console.log('nextPage', page, query)
      axios
        .get(`api/planPagination/${page}?page=${query}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
            this.pageInfo = response.data.pagination
            )
            console.log(this.pagi)
            console.log(this.pageInfo)
          }
        })
    },
    insertAlert() {
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
        title: 'Data Added successfully',
        color: 'green',
        timer: 5000,
      })
    },

    DeleteAlert() {

      this.$swal.fire({
        icon: 'error',
        title: 'Do you want to Delete',
        showDenyButton: true,
        showCancelButton: true,
        showConfirmButton:false,
        denyButtonText: `Deleted`,
      }).then(result => {

        if (result.isDenied) {
          this.deleteData()

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
            title: `Data Deleted successfully`,
            color: 'red',
            timer: 10000,
          })
        }
      })
    },

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

    getAllplans(){
      axios
        .get('api/plan')
        .then(response =>(this.plans = response.data.data))
    },

    exportExecl(){
      const XLSX = xlsx
      const workbook = XLSX.utils.book_new()
      const worksheet = XLSX.utils.aoa_to_sheet(this.framework1)

      XLSX.utils.book_append_sheet(workbook, worksheet, "framework")
      XLSX.writeFile(workbook,"users.xlsx")
    },

    Downpdf(){
      let docDefinition = {
        content: [
          {
            layout: 'lightHorizontalLines',
            table: {
              headerRows: 1,
              widths: [ '*', "auto",100,"*"],

              body:  this.framework1,

            },
          },
        ],
      }

      // pdfMake.createPdf(docDefinition).open()
      pdfMake.createPdf(docDefinition).download()

      // pdfMake.createPdf(docDefinition).print()

    },

    saveFeature(value) {
      this.features_type_selected_ids.push(value)
      console.log('saveFeature', this.features_type_selected_ids[1])
    },

    Add(){

      console.log(this.features_type)



      axios.post(
        "api/plan",
        {
          name: this.plan_name,
          periodicity: this.periodicity_of_plan,
          periodicity_type: this.periodicity_type,

        },
      ).then( res => {
        console.log(res.data.data[0].plan_id)
        this.plan_id = res.data.data[0].plan_id



        axios.post(
          `api/assosiative/${this.plan_id}`,  {
            featureID: this.features_type_selected_ids,
          },
        )

        this.plan_name= ''
        this.periodicity_of_plan= ''
        this.periodicity_type= ''

        this.getAllPaginate()

      },

      )

      //console.log(user),

      this.dialog = false,
      this.insertAlert()


    },

    async  Delete(GetId){
      this.planId = GetId
      this.DeleteAlert()
    },

    deleteData(){
      axios
        .delete(`api/plan/${this.planId}`)
        .then(response => (this.plans = response.data.data))
      this.getAllPaginate()
    },

    async  Updates(Getdata){

      this.planId = Getdata

      console.log(this.features_type_edit)

      this.plan_name_edit= Getdata.plan_name
      this.periodicity_of_plan_edit= Getdata.periodicity_of_plan
      this.grace_days_edit= Getdata.grace_days
      this.periodicity_type_edit= Getdata.periodicity_type
      this.features_type_edit= Getdata.features_type_selected_ids==0?false:true


    },

    async updateUser() {

      try {
        const user = await axios.put(
          `api/plan/${this.planId.plan_id}`,
          {
            name: this.plan_name_edit,
            periodicity: this.periodicity_of_plan_edit,
            grace_days: this.grace_days_edit,
            periodicity_type: this.periodicity_type_edit,
            featureID: this.features_type_edit,

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

    async getFeature(){
      axios
        .get('api/feature')
        .then(response => (this.features = response.data.data))

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
