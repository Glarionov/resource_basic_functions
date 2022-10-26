<template>
    <div>
        <Head title="Organizations" ><title>Organizations</title></Head>

        <h1>
            Apple list
        </h1>
        <div class="bg-white rounded-md shadow overflow-x-auto p-2 col-12 col-md-11 col-lg-10 col-xl-10 ma">
            <BaseTableWrapper :defaultColNames="this.defaultColNames" :mainObjects="mainObjects" :selectedRows="selectedRows">
                <template v-slot="slotProps">
                    <td class="border-t">
                        {{slotProps.mainObject.color}}
                    </td>
                    <td  class="border-t">
                        {{slotProps.mainObject.size}}
                    </td>
                    <td  class="border-t">
                        {{slotProps.mainObject.weight}}
                    </td>
                </template>
            </BaseTableWrapper>

            <div class="table-actions ">
                With selected:
                <div class="row">
                    <div class="change-size col-3">
                        Set size:
                        <form @submit.prevent="setNewSize">
                            <input type="text" v-model="setNewSizeForm.new_values.size">
                            <button type="submit" class="btn btn-success ml-1">Submit</button>
                        </form>
                    </div>
                    <div class="change-size col-3 offset-1">
                        Set weight:
                        <form @submit.prevent="setNewWeight">
                            <input type="text" v-model="setNewWeightForm.new_values.weight">
                            <button type="submit" class="btn btn-success ml-1">Submit</button>
                        </form>
                    </div>
                    <div class="change-size col-3 offset-1">
                        Delete selected:
                        <form @submit.prevent="deleteSelected">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue'
import BaseTableWrapper from "../../Shared/Tables/BaseTableWrapper";
// import Icon from '@/Shared/Icon'
// import pickBy from 'lodash/pickBy'
// import Layout from '@/Shared/Layout'
// import throttle from 'lodash/throttle'
// import mapValues from 'lodash/mapValues'
// import Pagination from '@/Shared/Pagination'
// import SearchFilter from '@/Shared/SearchFilter'

export default {
    components: {
        Head,
        BaseTableWrapper
        // Icon,
        // Link,
        // Pagination,
        // SearchFilter,
    },
    // layout: Layout,
    props: {
        mainObjects: Object,
        filters: Object,
        organizations: Object,
    },
    data() {
        return {
            defaultColNames: ['Color', 'Size', 'Weight'],
            newSize: null,
            selectedRows: [],

            massActionsForm: this.$inertia.form({
                new_values: {
                    size: null
                },
                filter: {
                    id: null
                }
            }),
            setNewSizeForm: this.$inertia.form({
                new_values: {
                    size: null
                },
                filter: {
                    id: null
                }
            }),
            setNewWeightForm: this.$inertia.form({
                new_values: {
                    weight: null,
                },
                filter: {
                    id: null
                }
            }),
            form: this.$inertia.form({

            }),
        }
    },
    watch: {
        form: {
            deep: true,
            // handler: throttle(function () {
            //     this.$inertia.get('/organizations', pickBy(this.form), { preserveState: true })
            // }, 150),
        },
    },
    methods: {
        reset() {
            // this.form = mapValues(this.form, () => null)
        },
        setNewSize() {
            // this.setNewSizeForm.filter.id = Object.keys(this.selectedRows);
            // this.setNewSizeForm.put('/api/apples-list');
            // this.form.patch(`/organizations/1`)
            this.form.put(`/organizations/1`)
        },
        setNewWeight() {
            this.setNewWeightForm.filter.id = Object.keys(this.selectedRows);
            this.setNewWeightForm.put('/api/apples-list');
        },
        deleteSelected() {
            this.massActionsForm.filter.id = Object.keys(this.selectedRows);
            /*s*/console.log('this.massActionsForm=', this.massActionsForm); //todo r
            this.massActionsForm.delete('/api/apples-list');
            // this.$inertia.delete('/api/apples', this.massActionsForm);
        }
    },
}
</script>
