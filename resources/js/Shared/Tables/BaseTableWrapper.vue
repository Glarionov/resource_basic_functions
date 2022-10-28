<template>
    <table class="table">
        <thead>
        <tr class="text-left font-bold table">
            <th v-if="showSelectCheckboxes" class="pb-4 pt-6 px-6" scope="col">
                <a href="" @click.prevent="selectAll">
                    Select all
                </a>
            </th>
            <th v-if="showIds" class="pb-4 pt-6 px-6" scope="col">
                ID
            </th>
            <th class="pb-4 pt-6 px-6" v-for="(defaultColName, defaultColNameIndex) in defaultColNames" :key="defaultColNameIndex"
                scope="col"
            >
                {{defaultColName}}
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="mainObject in mainObjects.data" :key="mainObject.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td v-if="showSelectCheckboxes"  class="border-t" scope="row">
                <input type="checkbox" v-model="selectedRows[mainObject.id]">
            </td>
            <td v-if="showIds"  class="border-t" scope="row">
                {{mainObject.id}}
            </td>
            <slot :mainObject="mainObject"></slot>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "BaseTableWrapper",
    props: {'defaultColNames': {}, 'mainObjects': {},
        showIds: {
            type: Boolean,
            default: true
        },
        showSelectCheckboxes: {
            type: Boolean,
            default: true
        },
        selectedRows: {
            type: Array,
            default: []
        },
        selectedAll: {

        }
        // selectAll: {
        //     type: Function
        // }
    },
    data: () => {
        return {
            // selected: []
        }
    },
    methods: {
        selectAll(){
            this.$parent.selectAll(!selectedAll);
        }
    }
}
</script>

<style scoped>

</style>
