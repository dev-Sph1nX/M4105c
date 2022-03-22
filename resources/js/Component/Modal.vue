<template>
    <div :class="{hidden : !value}" class="overflow-y-auto overflow-x-hidden fixed top-4 z-50 justify-center items-center md:inset-0 h-modal sm:h-full p-10 w-full animate-fade-opa flex" style="background: rgba(0,0,0,0.4);" id="large-modal">
        <div class="relative px-4 w-full max-w-4xl h-full md:h-auto m-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-5 rounded-t border-b">
                    <!-- Ajouter ticket -->
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                        <slot name="title">

                        </slot>
                    </h3>
                    
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" @click="$emit('input', false)">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <!-- Modal body -->

                <slot>

                </slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        value: {
            type : Boolean,
            default: false
        },
    },
    watch:{
        value(value){
            value ? document.body.style.overflow = 'hidden' : document.body.style.overflow = '';
        }
    }
}
</script>