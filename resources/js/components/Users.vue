<template>
    <div class="container">
        <page-title title="Les Utilisateurs (Le Personnel)"/>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste du Personnel</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!users.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas de personnels disponible...</tr>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td><span class="tag tag-success">{{convert(user.created_at)}}</span></td>
                      <td>
                          <button class="btn btn-success btn-sm">View</button>
                          <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">Delete</button>
                      </td>
                    </tr>
                    
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                    users:[],
            }
        },
        methods:{
           convert(jour){
                let  date =  new Date(jour);
                return  date.toDateString() // "sun nov 29 2020 "
            },
            loadUsers(){
                axios.get('api/users').then((users)=>{
                    this.users = users.data;
                })
            },
            deleteUser(id){
                    Swal.fire({
                    title: 'Etes vous sûr???',
                    text: "Pas de récuperation possible!!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimer le'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`api/users/${id}`).then(()=>{
                                    Swal.fire(
                                    'Deleted!',
                                    'Utilisateur a été supprimé.',
                                    'success'
                                    )
                                this.loadUsers();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Utilisateur toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteUsers
        },
        created(){
            this.loadUsers();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
