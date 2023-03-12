<script setup>
import {
  betweenValidator,
  requiredValidator,
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

            style="width: 70%;"
          >
            {{ $t('Search') }}
          </VTextField>
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
              {{ $t('Add Room Type') }}
            </VBtn>
          </template>
          <VCard>
            <VCardTitle>
              <span class="text-h5">Add New Room Type</span>
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
                      v-model="room_type_code"
                      label="room type code"
                      persistent-placeholder
                      :rules="[requiredValidator, betweenValidator(room_type_code, 1, 20)]"
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="room_type_name"
                      label="room type name"
                      persistent-placeholder
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="room_type_loc"
                      label="اسم نوع الغرفة"
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
                      v-model="room_type_pax"
                      label="def pax"
                      persistent-placeholder
                      type="number"
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="room_type_price"
                      label="def price"
                      persistent-placeholder
                      type="number"
                    />
                  </VCol>


                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="room_type_number"
                      label="number of rooms"
                      persistent-placeholder
                      type="number"
                    />
                  </VCol>


                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VCheckbox
                      v-model="room_type_rent"
                      :label="`room type rentable: ${room_type_rent.toString()}`"
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
          <th class="text-left">
            {{ $t('Type code') }}
          </th>
          <th
            class="text-left"
          >
            {{ $t('type name') }}
          </th>

          <th class="text-left">
            {{ $t('def pax') }}
          </th>
          <th class="text-left">
            {{ $t('Room number') }}
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
          v-for="item in filterData"
          :key="item.id"
          style="text-align: left"
        >
          <td>{{ item.rm_type_code }}</td>


          <td>
            <p v-if="$i18n.locale === 'en'">
              {{ item.rm_type_name }}
            </p>    <p v-else="$i18n.locale === 'ar'">
              {{ item.rm_type_name_loc }}
            </p>
          </td>


          <td>{{ item.no_of_rooms }}</td>



          <td>{{ item.def_pax }}</td>


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
                      <span class="text-h5">UPDATE New Room Type</span>
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
                              v-model="room_type_code_edit"
                              label="room type code"
                              :rules="[requiredValidator, betweenValidator(room_type_code_edit, 10, 20)]"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_type_name_edit"
                              label="room type name"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_type_loc_edit"
                              label="اسم نوع الغرفة"
                              type="text"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_type_pax_edit"
                              label="def pax"
                              persistent-hint
                              type="number"
                            />
                          </VCol>

                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_type_price_edit"
                              label="def price"
                              persistent-placeholder
                              type="number"
                            />
                          </VCol>


                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_type_number_edit"
                              label="number of rooms"
                              persistent-hint
                              type="number"
                            />
                          </VCol>


                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VCheckbox
                              v-model="room_type_rent_edit"
                              :label="`room type rentable: ${room_type_rent_edit.toString()}`"
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
                        Submit
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

// import xlsx from "xlsx/dist/xlsx.full.min"
// import pdfMake from "pdfmake/build/pdfmake"
// import pdfFonts from "pdfmake/build/vfs_fonts"
// import router from "@/router"
//
// pdfMake.vfs = pdfFonts.pdfMake.vfs

export default {
  name: "RoomTypeTable",

  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      search:'',
      dialog: false,
      dialog3: false,
      Types:[],
      typeid:'',
      id: '',

      room_type_code : ref(''),
      room_type_name:'',
      room_type_loc:'',
      room_type_pax:'',
      room_type_price:'',
      room_type_number:'',
      room_type_rent:true,



      room_type_code_edit:ref(''),
      room_type_name_edit:'',
      room_type_loc_edit:'',
      room_type_pax_edit:'',
      room_type_price_edit:'',
      room_type_number_edit:'',
      room_type_rent_edit:'',

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

      return  this.pagi.filter(user => {
        return user.rm_type_name.includes(this.search)||
          user.room_type_loc.includes(this.search)||
          user.room_type_pax.includes(this.search)
        user.room_type_number.includes(this.search)
        user.room_type_price.includes(this.search)
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
    this.getAllTypes()
    this.getAllPaginate()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
    async getAllPaginate(){
      console.log(this.pageSize)
      axios
        .get(`api/room_types_pagination/${this.pageSize}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
            this.pageInfo = response.data
            )
            console.log(this.pagi)
            console.log(this.pageInfo)
          }
        })

    },

    nextPage(page, query) {
      console.log('nextPage', page, query)
      axios
        .get(`api/room_types_pagination/${page}?page=${query}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
            this.pageInfo = response.data
            )
            console.log(this.pagi)
            console.log(this.pageInfo)
          }
        })
    },
    getAllTypes(){
      axios
        .get('api/room_types')
        .then(res => {
          this.Types = res.data
          console.log(this.Types)
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
            title: `Data ${this.room_name_en} Deleted successfully`,
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


    async  Add(){

      try {
        const user = await axios.post(
          "api/room_types/",
          {
            rm_type_code: this.room_type_code,
            rm_type_name: this.room_type_name,
            rm_type_name_loc: this.room_type_loc,
            def_pax: this.room_type_pax,
            def_price: this.room_type_price,
            no_of_rooms: this.room_type_number,
            rm_type_rentable:  this.room_type_rent,


            sort_order: 1,
            scth_type_code: 2,
            def_rate_code: 'qwwq',
          },
        )


        this.getAllTypes()
        this.dialog = false
        this.insertAlert()
        this.room_type_code = ref('')
        this.room_type_name=''
        this.room_type_loc=''
        this.room_type_pax=''
        this.room_type_price=''
        this.room_type_number=''
        this.room_type_rent=true

      } catch(e) {
        console.log(e)
      }
    },


    async  Delete(GetId){
      this.typeid = GetId
      this.DeleteAlert()
    },


    deleteData(){
      console.log(this.typeid)
      axios
        .delete(`api/room_types/${this.typeid}`)
        .then(response => (this.Types = response.data))
      this.getAllPaginate()
    },



    async  Updates(Getdata){

      this.typeid = Getdata

      this.room_type_code_edit = Getdata.rm_type_code
      this.room_type_name_edit = Getdata.rm_type_name
      this.room_type_loc_edit = Getdata.rm_type_name_loc
      this.room_type_pax_edit = Getdata.def_pax
      this.room_type_price_edit = Getdata.def_price
      this.room_type_number_edit = Getdata.no_of_rooms
      this.room_type_rent_edit = Getdata.rm_type_rentable==0?false:true
    },


    async updateUser() {
      try {
        const user = await axios.put(

          `api/room_types/${this.typeid.id}`,
          {

            rm_type_code: this.room_type_code_edit,
            rm_type_name: this.room_type_name_edit,
            rm_type_name_loc: this.room_type_loc_edit,
            def_pax: this.room_type_pax_edit,
            def_price: this.room_type_price_edit,
            no_of_rooms: this.room_type_number_edit,
            rm_type_rentable : this.room_type_rent_edit,


            sort_order: 1,
            scth_type_code: 2,
            def_rate_code: 'qwwq',
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
