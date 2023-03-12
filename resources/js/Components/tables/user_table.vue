<script setup>
import {
  alphaDashValidator,
  alphaValidator,
  betweenValidator,
  confirmedValidator,
  emailValidator,
  integerValidator,
  lengthValidator,
  passwordValidator,
  regexValidator,
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

            label="Search Users"
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
              Add Users
            </VBtn>
          </template>
          <VCard>
            <VCardTitle>
              <span class="text-h5">User Profile</span>
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
                      v-model="firstname"
                      label="first name"
                      required
                      persistent-placeholder
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="lastname"
                      label="last name"
                      persistent-placeholder
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField
                      v-model="phonenumber"
                      label="phone"
                      persistent-placeholder
                      :rules="[requiredValidator, regexValidator(phonenumber, '^([0-9]+)$')]"
                      required
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                  >
                    <VSelect
                      v-model="role"
                      :items="Role_type"
                      item-title="role type"
                      item-value="id"
                      persistent-placeholder
                      label="role type"
                      :rules="[requiredValidator]"
                    />
                  </VCol>
                  <VCol cols="12">
                    <VTextField
                      v-model="email"
                      label="Email"
                      required
                      persistent-placeholder
                      :rules="[requiredValidator,emailValidator]"
                    />
                  </VCol>
                  <VCol cols="12">
                    <VTextField
                      v-model="password"
                      label="Password"
                      type="password"
                      required
                      persistent-placeholder
                      :rules="[requiredValidator]"
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
        export
      </VBtn>
      <VBtn
        class="btn"
        @click="Downpdf"
      >
        PDF
      </VBtn>
    </div>

    <br>
    <br>
    <br>

    <VTable>
      <thead>
        <tr>
          <th class="text-right">
            firstname
          </th>
          <th class="text-right">
            lastname
          </th>
          <th class="text-right">
            phone
          </th>
          <th class="text-right">
            email
          </th>
          <th class="text-right">
            role
          </th>
          <th class="text-right">
            status
          </th>
          <th class="text-right">
            Delete
          </th>
          <th class="text-right">
            Update
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in filterData"
          :key="item.id"
          style="text-align: right"
        >
          <td>{{ item.firstname }}</td>
          <td>{{ item.lastname }}</td>
          <td>{{ item.phonenumber }}</td>
          <td>{{ item.email }}</td>
          <td>
            <VChip
              class="ma-2"
              color="primary"
              variant="outlined"
            >
              {{ item.role }}
              <VIcon
                end
                icon="mdi-account-outline"
              />
            </VChip>
          </td>
          <td>
            <VChip
              class="ma-2"
              style="color:red;"
            >
              <VIcon
                start
                icon="mdi-account-circle-outline"
              />
              Pending
            </VChip>
          </td>
          <td>
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
                              v-model="firstname_edit"
                              label="first name edit"
                              required
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="lastname_edit"
                              label="last name"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="phonenumber_edit"
                              label="phone"
                              persistent-hint
                              required
                              type="number"
                            />
                          </VCol>

                          <VCol
                            cols="12"
                            sm="6"
                          >
                            <VSelect
                              v-model="role_edit"
                              :items="Role_type"
                              label="role"
                              required
                            />
                          </VCol>
                          <VCol cols="12">
                            <VTextField
                              v-model="email_edit"
                              label="Email"
                              required
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
      <br>
      <caption>List Of Registered Users(  5 )</caption>
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
  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      name: "user_table",
      search:'',
      dialog: false,
      dialog3: false,
      getusers:[],
      userid:'',
      firstname: '',
      lastname: '',
      phonenumber: ref(''),
      email: ref(''),
      role:'',
      Role_type: ['User', 'Owner'],
      password: ref(''),


      firstname_edit: '',
      lastname_edit: '',
      phonenumber_edit: '',
      email_edit: '',
      role_edit: '',
      password_edit: '',



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
      // eslint-disable-next-line sonarjs/no-identical-expressions
      return  this.pagi.filter(user => {
        return user.firstname.includes(this.search)||
          user.lastname.includes(this.search)||
          user.phonenumber.includes(this.search)
        user.email.includes(this.search)
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
    this.getAllUsers()
    this.getAllPaginate()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
    async getAllPaginate(){
      console.log(this.pageSize)
      axios
        .get(`api/userPagination/${this.pageSize}`)
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
        .get(`api/userPagination/${page}?page=${query}`)
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
    getAllUsers(){
      axios
        .get('api/user')
        .then(res => {

          this.getusers = res.data
          console.log(this.getusers)
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

      console.log(this.role)

      try {
        const user = await axios.post(
          "api/user/",
          {
            firstname: this.firstname,
            lastname: this.lastname,
            phonenumber: this.phonenumber,
            email: this.email,
            password: this.password,
            role: this.role,
          },
        )

        console.log(user)
        this.getAllPaginate()
        this.dialog = false
        this.insertAlert()
      } catch(e) {
        console.log(e)
      }
    },


    async  Delete(GetId){
      this.userid = GetId
      this.DeleteAlert()
    },


    deleteData(){
      console.log(this.userid)
      axios
        .delete(`api/user/${this.userid}`)
        .then(response => (this.getusers = response.data))
      this.getAllPaginate()
    },



    async  Updates(Getdata){

      this.userid = Getdata

      console.log(Getdata)

      this.firstname_edit = Getdata.firstname
      this.lastname_edit = Getdata.lastname
      this.phonenumber_edit = Getdata.phonenumber
      this.email_edit = Getdata.email
      this.password_edit = Getdata.password
      this.role_edit = Getdata.role



    },


    async updateUser() {
      try {
        const user = await axios.put(

          `api/user/${this.userid.id}`,
          {

            firstname: this.firstname_edit,
            lastname: this.lastname_edit,
            phonenumber: this.phonenumber_edit,
            email: this.email_edit,
            role: this.role_edit,

          },
        )

        console.log(user)
        this.getAllPaginate()
        this.getAllFloors()
        this.dialog3 = false
        this.UpdateAlert()
      } catch(e) {
        console.log(e)
      }





    },


  },
}
</script>
