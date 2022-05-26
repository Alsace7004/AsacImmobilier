<template>
    <div class="container">
        <page-title title="Fuck Off!!!"/>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        methods:{
            bonjour(){
                alert("bonjour tout le monde!!! je suis executer!!!");
            }
        },
        created(){
            this.bonjour();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
