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
              {{ $t('Add Role') }}
            </VBtn>
          </template>
          <VCard>
            <VCardTitle>
              <span class="text-h5">{{ $t('Add New Role') }}</span>
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
                      v-model="Roles_name"
                      label="Roles name"
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
          {{ $t('Num of Roles') }}
        </th>
        <th class="text-right">
          {{ $t('Roles name') }}
        </th>
      </tr>
      </thead>


      <tbody>
      <tr
        v-for="(item , index) in Roles"
        :key="item.id"
        style="text-align: right"
      >
        <td> {{ ++index }}</td>

        <td>{{ item.name }}</td>
      </tr>
      </tbody>
      <br>
      <caption> {{ $t('List Of Data') }}(  {{ count }} )</caption>
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
  name: "PermissionTable",

  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      search:'',
      dialog: false,
      Roles:[],
      Rolesid:'',

      Roles_name:'',


      count:0,

      pagi:[],
      page:2,
      pageInfo:null,
      totalPages: 4,
      pageSize: 5,
      perPage:10,

      pageSizes: [5, 10, 15,20,25,30],



    }
  },



  // eslint-disable-next-line vue/component-api-style
  computed:{
    filterData(){
      return  this.pagi.filter(user => {
        return  user.name.includes(this.search)

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
    this.getAllRoles()
    this.getAllPaginate()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
    async getAllPaginate(){
      // console.log(this.pageSize)
      axios
        .get(`api/getAllPermissionPaginate/${this.pageSize}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
                this.pageInfo = response.data.data
            )
            // console.log(this.pagi)
            // console.log(this.pageInfo)
          }
        })

    },
    nextPage(page, query) {
      console.log('nextPage', page, query)
      axios
        .get(`api/getAllPermissionPaginate/${page}?page=${query}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
                this.pageInfo = response.data.data
            )
            // console.log(this.pagi)
            // console.log(this.pageInfo)
          }
        })
    },


    save (date) {
      this.$refs.menu.save(date)
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


    getAllRoles(){
      axios
        .get('api/getAllPermissios')
        .then(response => (this.Roles = response.data.data))
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
          "api/storePermission",
          {
            name : this.Roles_name,
          },
        )

        this.Roles_name=''
        this.getAllPaginate()
        this.dialog = false
        this.insertAlert()
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
