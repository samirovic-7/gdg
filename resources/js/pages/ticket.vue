<!-- eslint-disable vue/require-v-for-key -->
<script setup>
import {
  emailValidator,
  requiredValidator,
} from '@validators'
</script>

<template>
  <div style="margin-top: 5%">
    <div style="float: right;width: 45%;display: flex;justify-content: space-between;">
      <VRow justify="">
        <div style="width: 65%;display: flex;justify-content: space-between">
          <VSelect label="row" :items="['10', '20', '30', '40']" variant="solo" style="width: 18%;" />
          <VSpacer />
          <VTextField v-model="search" type="text" label="Search" style="width: 70%;" />
        </div>
        <VSpacer />
      </VRow>
    </div>
    <div style="float: left;width: 14%;display: flex;justify-content: space-between">
      <VBtn class="btn" @click="exportExecl">
        export
      </VBtn>
      <VBtn class="btn" @click="Downpdf">
        PDF
      </VBtn>
    </div>

    <br>
    <br>
    <br>

    <VTable>
      <thead>
        <tr>
          <th class="text-left">
            Ticket number
          </th>
          <th class="text-left">
            Username
          </th>
          <th class="text-left">
            Title
          </th>
          <th class="text-left">
            Priority
          </th>
          <th class="text-left">
            Status
          </th>
          <th class="text-left">
            Resolved
          </th>
          <th class="text-left">
            Locked
          </th>
          <th class="text-left">
            Delete
          </th>
          <th class="text-left">
            Show and edit
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in tickets" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.user.firstname + ' ' + item.user.lastname }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.priority }}</td>
          <td>{{ item.status }}</td>
          <td>
            <VChip class="ma-2">
              <VIcon v-if="item.is_resolved" icon="mdi-check" color="success" />
              <VIcon v-if="!item.is_resolved" icon="mdi-close-octagon" color="error" />
            </VChip>
          </td>
          <td>
            <VChip class="ma-2">
              <VIcon v-if="item.is_locked" icon="mdi-check" color="success" />
              <VIcon v-if="!item.is_locked" icon="mdi-close-octagon" color="error" />
            </VChip>
          </td>
          <td>
            <VBtn color="primary" @click="Delete(item.id)">
              <VIcon icon="mdi-delete" />
            </VBtn>
          </td>
          <td>
            <VBtn color="primary">
              <VRow>
                <VDialog v-model="item.dialogVisible" width="1024">
                  <template #activator="{ props }">
                    <VBtn v-bind="props" @click="Updates(item)">
                      <VIcon icon="mdi-file-edit-outline" />
                    </VBtn>
                  </template>
                  <VCard>
                    <VCardTitle>
                      <span class="text-h5">Show and update Ticket</span>
                    </VCardTitle>
                    <VCardText>
                      <VContainer>
                        <div v-if="hasupdateErrors">
                          <div v-for="(error, key) in update_errors" :key="key">
                            <VAlert closable close-label="Close Alert" class="mb-5">
                              {{ error[0] }}
                            </VAlert>
                          </div>
                        </div>
                        <VRow>
                          <VCol cols="12" sm="6" md="12">
                            <VTextField v-model="title_edit" label="Title" disabled :rules="[requiredValidator]" />
                          </VCol>
                          <VCol cols="12" sm="6" md="12">
                            <VTextarea v-model="message_edit" label="Message" disabled :rules="[requiredValidator]" />
                          </VCol>
                          <VCol cols="12" sm="6" md="12">
                            <VTextarea v-model="comment" label="Comment" :rules="[requiredValidator]" />
                          </VCol>
                          <VCol cols="12" sm="6" md="6">
                            <VSelect v-model="priority_edit" :items="priorities" item-title="name" item-value="name"
                              label="Priority" persistent-hint :rules="[requiredValidator]" />
                          </VCol>

                          <VCol cols="12" sm="6">
                            <VSelect v-model="status_edit" :items="statuses" item-title="name" item-value="name"
                              label="status" persistent-hint :rules="[requiredValidator]" />
                          </VCol>
                          <VCol cols="12" sm="6" md="6">
                            <VCheckbox v-model="is_resolved_edit" label="Is_resolved" persistent-hint />
                          </VCol>
                          <VCol cols="12" sm="6">
                            <VCheckbox v-model="is_locked_edit" label="Is_locked" persistent-hint />
                          </VCol>

                          <VCol cols="6" sm="12">

                            <div v-for="files in item.ticket_files" :key="files.id">
                              <a :href="files.file" download>{{ files.file }}</a>
                              <br>
                            </div>
                          </VCol>
                        </VRow>
                      </VContainer>
                    </VCardText>
                    <VCardActions>
                      <VSpacer />
                      <VBtn color="blue-darken-1" variant="text"
                        @click="item.dialogVisible = false, update_errors = null">
                        Close
                      </VBtn>
                      <VBtn color="blue-darken-1" variant="text" @click="updateticket">
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
    </VTable>
    <div style="float: right">
      <VPagination v-model="page" :length="10" :total-visible="7" :data="users" @pagination-change-page="getPosts" />
    </div>
  </div>
</template>

<script>
import axiosIns from "axios"
import Swal from 'sweetalert2'


export default {
  name: "ticket",
  // eslint-disable-next-line vue/component-api-style
  data() {
    return {
      search: '',
      page: 1,
      dialog: false,
      dialog3: false,
      priorities: ['high', 'normal', 'low'],
      statuses: ['open', 'closed'],
      tickets: [
        {
          id: '',
          user: {},
          title: '',
          message: '',
          priority: '',
          status: '',
          is_resolved: '',
          is_locked: '',
          ticket_files: [],
        },
      ],
      ticket: {
        id: '',
        firstname: '',
        lastname: '',
        username: '',
        title: '',
        message: '',
        priority: '',
        status: '',
        is_locked: '',
        is_resolved: '',
      },
      id_edit: '',
      title_edit: '',
      message_edit: '',
      priority_edit: '',
      status_edit: '',
      is_resolved_edit: '',
      is_locked_edit: '',
      comment: '',
      errors: null,
      update_errors: null,
      isSnackbarVisible: ref(false),


    }
  },
  // eslint-disable-next-line vue/component-api-style
  computed: {
    filterData() {
      return this.tickets.filter(ticket => ticket.includes(this.search))
    },
    hasErrors() {
      return this.errors !== null
    },
    hasupdateErrors() {
      return this.update_errors !== null
    },
  },
  // eslint-disable-next-line vue/component-api-style
  mounted() {
    this.getAlltickets()
  },

  // eslint-disable-next-line vue/component-api-style
  methods: {


    getAlltickets() {
      axiosIns
        .get('api/tickets', {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
            'Accept': 'application/json',
          },
        })
        .then(res => {

          this.tickets = res.data
          console.log(this.tickets)
        })
        .catch(
          err => {
            console.log(err)
          },
        )
    },

    Delete(GetId) {
      this.ticket_id = GetId
      this.DeleteAlert()
    },
    async deleteData() {
      axiosIns
        .delete(`api/tickets/${this.ticket_id}`, {
          headers: {
            Accept: 'application/json',
            Authorization: 'Bearer ' + localStorage.getItem('accessToken'),
          },
        })
        .then(res => {
          this.getAlltickets()
        }).catch(
          err => {
            console.log(err)
          },
        )

    },

    async Updates(Getdata) {
      console.log(Getdata.is_resolved)

      this.id_edit = Getdata.id
      this.title_edit = Getdata.title
      this.message_edit = Getdata.message
      this.priority_edit = Getdata.priority
      this.status_edit = Getdata.status
      this.is_resolved_edit = Getdata.is_resolved==0?false:true
      this.is_locked_edit = Getdata.is_locked==0?false:true
      this.comment = Getdata.comment
    },
    async updateticket() {
      const data = {
        title: this.title_edit,
        message: this.message_edit,
        priority: this.priority_edit,
        status: this.status_edit,
        is_resolved: this.is_resolved_edit,
        is_locked: this.is_locked_edit,
        comment: this.comment,
      }

      await axiosIns.put(`api/tickets/${this.id_edit}`, data, {
        headers: {
          Accept: 'application/json',
          Authorization: 'Bearer ' + localStorage.getItem('accessToken'),
        },
      }).then(
        res => {
          this.getAlltickets()
          this.dialog3 = false
          this.UpdateAlert()
        },
      ).catch(
        err => {
          this.update_errors = err.response.data.errors
        },
      )
    },

    exportExecl() {
      const XLSX = xlsx
      const workbook = XLSX.utils.book_new()
      const worksheet = XLSX.utils.aoa_to_sheet(this.framework1)

      XLSX.utils.book_append_sheet(workbook, worksheet, "framework")
      XLSX.writeFile(workbook, "users.xlsx")
    },
    Downpdf() {
      let docDefinition = {
        content: [
          {
            layout: 'lightHorizontalLines',
            table: {
              headerRows: 1,
              widths: ['*', "auto", 100, "*"],

              body: this.framework1,

            },
          },
        ],
      }

      // pdfMake.createPdf(docDefinition).open()
      pdfMake.createPdf(docDefinition).download()

      // pdfMake.createPdf(docDefinition).print()

    },

    insertAlert() {
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'New Ticket has been created',
        timer: 2000,
      })
    },
    DeleteAlert() {

      Swal.fire({
        icon: 'error',
        title: 'Delete this ticket?',
        showDenyButton: true,
        showCancelButton: true,
        showConfirmButton: false,
        denyButtonText: `Delete`,
      }).then(result => {

        if (result.isDenied) {
          this.deleteData()
        }
      })
    },
    UpdateAlert() {
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Ticket has been updated',
        showConfirmButton: true,
        timer: 2000,
      })
    },
  },
}
</script>
