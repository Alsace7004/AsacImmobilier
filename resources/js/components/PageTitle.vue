<template>
    <div class="container">
        
                   <div class="content-header">
                    <div class="container-fluid">
                      <div class="row mb-2">
                        <div class="col-sm-6">
                          <h3 class="m-0">{{title}}</h3>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                          </ol>
                        </div><!-- /.col -->
                      </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                  </div> 
    </div>
</template>

<script>
    export default {
        props:{
            title:String
        },
        methods:{
           
        },
        created(){
          
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
