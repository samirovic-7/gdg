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
            label="row"
            :items="['10', '20', '30', '40']"
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
              Add plan
            </VBtn>
          </template>
          <VCard>
            <VCardTitle>
              <span class="text-h5">Add New Plan</span>
            </VCardTitle>
            <VCardText>
              <VContainer>
                <VRow>
                  <VCol
                    cols="12"
                    md="6"
                    sm="6"
                  >
                    <VSelect
                      v-model="plans_selected"
                      :items="plans"
                      item-title="plans type"
                      item-value="plan_id"
                      persistent-placeholder
                      label="plans type"
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

    <VTable style="table-layout: fixed">
      <thead>
        <tr>
          <th class="text-left">
            Num
          </th>
          <th class="text-left">
            plan name
          </th> <th class="text-left">
            feature name
          </th>

          <th class="text-left">
            Delete
          </th>
          <th class="text-left">
            Update
          </th>
        </tr>
      </thead>


      <tbody>
        <tr
          v-for="(item , index) in plans"
          :key="item.id"
          style="text-align: left"
        >
          <td> {{ ++index }}</td>

          <td>{{ item.plan_name }}</td>
          <td
            v-for="(element , index) in item.features"
            :key="element.id"
          >
            {{ element.name }}
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
                            sm="6"
                            md="6"
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
                              v-model="grace_days_edit"
                              label="grace day"
                              type="number"
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
                              type="text"
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
      <caption>List Of Data( 1 )</caption>
    </VTable>
    <div style="float: right">
      <VPagination
        v-model="page"
        :length="10"
        :total-visible="7"
        :data="roles"
        @pagination-change-page="getPosts"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios"



export default {
  name: "PlanFeatureTable",

  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      search:'',
      dialog: false,
      dialog3: false,

      plans:[],
      features:[],
      plans_selected:'',

      planId:'',

      plan_id: '',

      plan_name: '',
      periodicity_of_plan: '',

    }
  },

  // eslint-disable-next-line vue/component-api-style
  // computed:{
  //   filterData(){
  //
  //     return  this.plans.filter(user =>user.plan_name.includes(this.search))
  //   },
  // },

  // eslint-disable-next-line vue/component-api-style
  mounted() {
    this.getAllplans()
    this.getFeature()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
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




    async  Add(){
      console.log(this.plans_selected)
      console.log(this.plans.planId)
      console.log(this.plans.plan_id)
    },

    async  Delete(GetId){
      this.planId = GetId
      this.DeleteAlert()
    },

    deleteData(){
      axios
        .delete(`api/plan/${this.planId}`)
        .then(response => (this.plans = response.data.data))
      this.getAllplans()
    },


    async getFeature(){
      axios
        .get('api/feature')
        .then(res => (this.features = res.data.data))
    },

    getAllplans(){
      axios
        .get('api/plan')
        .then(response =>(this.plans = response.data.data))
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
