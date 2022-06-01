<template>
    <div class="container">
        <page-title title="Les Signatures"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Signature</h3>

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
                      <th>Avocat</th>
                      <th>Promesse Vente</th>
                      <th>Signature Acquereur</th>
                      <th>Signature Directeur Commercial</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!signatures.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas de signatures disponible...</tr>
                    <tr v-for="signature in signatures" :key="signature.id">
                      <td>{{signature.id}}</td>
                      <td>{{signature.nom}} {{signature.prenom}}</td>
                      <td>{{signature.client_appartement_immeuble}}</td>
                      <td>{{(signature.signaturePromesseAcquereur)}}</td>
                      <td>{{signature.signaturePromesseDirecteurCommercial}}</td>
                      <td><span class="tag tag-success">{{convert(signature.created_at)}}</span></td>
                      <td>
                          <button @click="editSignature(signature.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteSignature(signature.id)" class="btn btn-danger btn-sm">Delete</button>
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
         <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Signature":"Add New Signature"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateSignature() : createSignature()" enctype="multipart/form-data">
                        <div class="modal-body">
                                     <div class="form-group">
                                        <select  v-model="signature.avocat_id" id="avocat_id" class="form-control">
                                            <option value="" hidden selected>Selectionner l'Avocat</option>
                                            <option v-for="avocat in avocats" :key="avocat.id" :value="avocat.id" >{{avocat.nom}} {{avocat.prenom}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select  v-model="signature.promesse_vente_id" id="promesse_vente_id" class="form-control">
                                            <option value="" hidden selected>Selectionner une promesse vente</option>
                                            <option v-for="promessevente in promesseventes" :key="promessevente.id" :value="promessevente.id" >{{promessevente.client_appartement_immeuble}}</option>
                                        </select>
                                    </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{is_Editing ?"Update":"Create"}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                promesseventes:[],
                avocats:[],
                signatures:[],
                signature:{
                    avocat_id:'',
                    promesse_vente_id:'',
                    signaturePromesseAcquereur:'',
                    signaturePromesseDirecteurCommercial:''
                },
                edit_id:'',
                is_Editing:false,
            }
        },
        methods:{
            convert(jour){
                let  date =  new Date(jour);
                return  date.toDateString() // "sun nov 29 2020 "
            },
            newModal(){
                this.signature={
                        avocat_id:'',
                        promesse_vente_id:'',
                        signaturePromesseAcquereur:'0',
                        signaturePromesseDirecteurCommercial:'0'
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadPromesseVentesCIA(){
                axios.get('api/clientIA').then((promesseventes)=>{
                    this.promesseventes = promesseventes.data;
                })
            },
            loadAvocats(){
                axios.get('api/avocats').then((avocats)=>{
                    this.avocats = avocats.data;
                })
            },
            loadSignatures(){
                axios.get('api/signatures').then((signatures)=>{
                    this.signatures = signatures.data;
                })
            },

            /*handleFileUpload1(){
                this.signature.signaturePromesseAcquereur = this.$refs.signaturePromesseAcquereur.files[0];
                console.log('valeur du this.file1',this.signature.signaturePromesseAcquereur);
            },
            handleFileUpload2(){
                this.signature.signaturePromesseDirecteurCommercial = this.$refs.signaturePromesseDirecteurCommercial.files[0];
                  console.log('valeur du this.file2',this.signature.signaturePromesseDirecteurCommercial);
            },*/
            createSignature(){
                let av_id = document.querySelector("#avocat_id").value;
                let pv_id = document.querySelector("#promesse_vente_id").value;
                if(av_id ==""||pv_id ==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                    axios.post('api/signatures',this.signature).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Signature Ajouter avec success.','success') ;
                        this.loadSignatures();
                    this.signature={
                        avocat_id:'',
                        promesse_vente_id:'',
                        signaturePromesseAcquereur:'0',
                        signaturePromesseDirecteurCommercial:'0'
                    }
                    }).catch((err)=>{
                        //Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            if(err.response.data.errors.promesse_vente_id){
                                //Swal.fire('Error !!!',`Cette Signature existe déjà ${err.response.data.errors.promesse_vente_id}`,'error')
                                Swal.fire('Error !!!',`Cette Signature existe déjà`,'error')
                            }else{
                                Swal.fire('Error !!!',`Une erreur est survenue`,'error')
                            }
                    });
            },
            deleteSignature(id){
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
                            axios.delete(`api/signatures/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'La Signature a été supprimé(e).',
                                    'success'
                                    )
                                
                                 this.loadSignatures();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Signature est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteSignature
             editSignature(id){
                axios.get(`api/signatures/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.signature.avocat_id = res.data.avocat_id;
                    this.signature.promesse_vente_id = res.data.promesse_vente_id;
                    this.signature.signaturePromesseAcquereur = res.data.signaturePromesseAcquereur;
                    this.signature.signaturePromesseDirecteurCommercial = res.data.signaturePromesseDirecteurCommercial;
                    this.is_Editing = true;
                })
            },
            updateSignature(){
                    axios.put(`api/signatures/${this.edit_id}`,this.signature).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Signature mise à jour avec success.','success')    
                        this.loadSignatures();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },

        },
        created(){
            this.loadAvocats();
            this.loadSignatures();
            this.loadPromesseVentesCIA();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
