<template>
    <div>
        <Head title="Organizations"><title>Organizations</title></Head>

        <h1>
            Apple list
        </h1>
        <div class="bg-white rounded-md shadow overflow-x-auto p-2">

            <Link class="btn btn-success" href="/apples/create">
                <span>Create</span>
                <span class="hidden md:inline">&nbsp;Apple</span>
            </Link>
            <div class="filters">
                <form @submit.prevent="search">
                    <div class="d-flex">
                        <div class="col-2 d-flex">
                            Size min:
                            <!--                        <input type="text" class="form-control-sm mx-2 w-25" v-model="filter.filter.size[0]">-->
                            <input type="text" class="form-control form-control-sm mx-2 w-25" v-model="filter.size[0]">
                        </div>

                        <div class="col-2 d-flex">
                            Size max:
                            <input type="text" class="form-control form-control-sm mx-2 w-25" v-model="filter.size[1]">
                        </div>

                        <div class="col-2 d-flex">
                            Weight:
                            <input type="text" class="form-control form-control-sm mx-2 w-25" v-model="filter.weight">

                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-success btn-sm ml-1">Submit</button>
                        </div>
<!--                        <input type="text" class="form-control-sm mx-2 w-25" v-model="filter.filter.size[1]">-->

                    </div>

                </form>


            </div>

            <div class=" col-12 col-md-11 col-lg-10 col-xl-10 ma">
                <BaseTableWrapper :defaultColNames="this.defaultColNames" :mainObjects="mainObjects"
                                  :selectAll="selectAll"
                                  :selectedRows="selectedRows"
                                  :selectWord="selectWord"
                >
                    <template v-slot="slotProps">
                        <td class="border-t">
                            {{ slotProps.mainObject.color }}
                        </td>
                        <td class="border-t">
                            {{ slotProps.mainObject.size }}
                        </td>
                        <td class="border-t">
                            {{ slotProps.mainObject.weight }}
                        </td>
                    </template>
                </BaseTableWrapper>
            </div>


            <div class="table-actions ">
                With selected:
                <div class="row">
                    <div class="change-size col-2">

                        <form @submit.prevent="setNewSize">
                            <div class="d-flex">
                                Set size:
                                <input type="text" class="form-control form-control-sm mx-2 w-25" v-model="newSize">
                                <button type="submit" class="btn btn-success btn-sm ml-1">Submit</button>
                            </div>

                        </form>
                    </div>
                    <div class="change-size col-2 offset-1">

                        <form @submit.prevent="setNewWeight">
                            <div class="d-flex">
                                Set weight:

                                <input type="text"  class="form-control form-control-sm mx-2 w-25" v-model="newWeight">
                                <button type="submit" class="btn btn-success btn-sm ml-1">Submit</button>
                            </div>

                        </form>
                    </div>
                    <div class="change-size col-1 offset-1">
                        <form @submit.prevent="deleteSelected">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>

            </div>

            <div v-if="errorMessage">
                {{ errorMessage }}
            </div>
        </div>
    </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue'
import BaseTableWrapper from '../../Shared/Tables/BaseTableWrapper';


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
        BaseTableWrapper,
        // Icon,
        Link,
        // Pagination,
        // SearchFilter,
    },
    // layout: Layout,
    props: {
        mainObjects: Object,
        filters: Object,
        organizations: Object,
        success: Boolean,
        error: String,
    },
    computed: {
        errorMessage() {
            return this.$page.props.hasOwnProperty('flash') ? this.$page.props.flash.errorMessage: '';
        },
        selectWord() {
            return this.selectedAll? 'Unselect': 'Select';
        }
    },
    data() {
        return {
            defaultColNames: ['Color', 'Size', 'Weight'],
            newSize: null,
            newWeight: null,
            selectedRows: [],
            selectedAll: false,
            filter: this.$inertia.form({
                // filter: {
                //     size: [null, null],
                //     weight: null
                // }
                size: [null, null],
                weight: null
            }),
            massActionsForm: this.$inertia.form({
                newValues: {
                    size: null
                },
                filter: {
                    id: null
                }
            }),
            setNewSizeForm: this.$inertia.form({
                newValues: {
                    size: null
                },
                filter: {
                    id: null
                }
            }),
            setNewWeightForm: this.$inertia.form({
                newValues: {
                    weight: null,
                },
                filter: {
                    id: null
                }
            }),
            form: this.$inertia.form({}),
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
        updateSelected(newValues) {
            let newForm = {...this.massActionsForm, newValues: {}};
            for (let param in newValues) {
                newForm.newValues[param] = newValues[param];
            }
            newForm.filter.id = Object.keys(this.selectedRows);
            newForm.put(`/api/apples`)
        },
        setNewSize() {
            this.updateSelected({size: this.newSize});
        },
        setNewWeight() {
            this.updateSelected({weight: this.newWeight});
        },
        deleteSelected() {
            this.massActionsForm.filter.id = Object.keys(this.selectedRows);
            /*s*/
            console.log('this.massActionsForm=', this.massActionsForm); //todo r
            this.massActionsForm.delete('/api/apples');
            // this.$inertia.delete('/api/apples', this.massActionsForm);
        },
        search() {
            this.filter.get('/api/apples', {
                preserveState: true
            });
        },
        selectAll() {
            let newValue = !this.selectedAll;
            this.selectedRows = [];
            for (let index in this.mainObjects.data) {
                this.selectedRows[this.mainObjects.data[index].id] = newValue;
            }
            this.selectedAll = newValue;
        }
    },
}
</script>
