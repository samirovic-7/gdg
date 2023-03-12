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

            label="Search Roles"
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
              Add Role
            </VBtn>
          </template>
          <VCard>
            <VCardTitle>
              <span class="text-h5">{{ $t('Add New segment') }}</span>
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
                      v-model="name"
                      label="segment name en"
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
                      v-model="name_loc"
                      label="segment name ar"
                      persistent-placeholder
                      type="text"
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
        <th class="text-right">
          {{ $t('Num of segment') }}
        </th>
        <th class="text-right">
          {{ $t('segment name') }}
        </th>
        <th class="text-right">

          {{ $t('Delete') }}
        </th>
        <th class="text-right">

          {{ $t('Update') }}
        </th>
      </tr>
      </thead>


      <tbody>
      <tr
        v-for="(item , index) in filterData"
        :key="item.id"
        style="text-align: right"
      >
        <td>{{++index}}</td>

        <td>
          <p v-if="$i18n.locale === 'en'">
            {{ item.name }}
          </p>
          <p v-else="$i18n.locale === 'ar'">
            {{ item.name_loc }}
          </p>
        </td>
        <td style="table-layout: fixed ">
          <VBtn
            color="primary"
            @click="Delete(item.id)"
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
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="name_edit"
                            label="name edit"
                            type="text"
                          />
                        </VCol>

                        <VCol
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <VTextField
                            v-model="name_loc_edit"
                            label="name loc edit"
                            type="text"
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
      <caption>{{ $t('List Of Data') }}( {{ count }} )</caption>
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

export default {
  name: "Segment",

  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      search:'',

      dialog: false,
      dialog3:false,

      segmentid:'',
      Segment:[],
      segment_id:'',

      name:'',
      name_loc:'',


      name_edit:'',
      name_loc_edit:'',


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

      return  this.pagi.filter(user =>{
        return  user.name.includes(this.search)||
          user.name_loc.includes(this.search)
      })
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
    this.getAllSegment()
    this.getAllPaginate()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
    async getAllPaginate(){
      // console.log(this.pageSize)
      axios
        .get(`api/segmentPaginate/${this.pageSize}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
            this.pageInfo = response.data
            )
            // console.log(this.pagi)
            // console.log(this.pageInfo)
          }
        })

    },

    nextPage(page, query) {
      console.log('nextPage', page, query)
      axios
        .get(`api/segmentPaginate/${page}?page=${query}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
                this.pageInfo = response.data
            )
            // console.log(this.pagi)
            // console.log(this.pageInfo)
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

    getAllSegment(){
      axios
        .get('api/segment')
        .then(response => (this.Segment = response.data))
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

      pdfMake.createPdf(docDefinition).download()


    },


    async  Add(){

      try {
        const user = await axios.post(
          "api/segment",
          {
            name : this.name,
            name_loc: this.name_loc,
          },

        )

        this.name=''
        this.name_loc=''

        this.getAllPaginate()
        this.dialog = false
        this.insertAlert()
      } catch(e) {
        console.log(e)
      }
    },

    async  Delete(GetId){
      this.segmentid = GetId
      this.DeleteAlert()
    },

    deleteData(){
      axios
        .delete(`api/segment/${this.segmentid}`)
        .then(response => (this.Segment = response))
      this.getAllPaginate()
    },

    async  Updates(Getdata){

      this.segmentid = Getdata



      this.name_edit= Getdata.name
      this.name_loc_edit= Getdata.name_loc

    // console.log(this.segmentid)
    },

    async updateUser() {

      try {
        const user = await axios.put(
          `api/segment/${this.segmentid.id}`,
          {
            name: this.name_edit,
            name_loc: this.name_loc_edit,

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
