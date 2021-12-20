<!-- Use preprocessors via the lang attribute! e.g. <template lang="pug"> -->
<template>
    <div id="app">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-search" aria-hidden="true"></i>
              </span>
                        </div>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Search here..."
                            aria-label="Search"
                            aria-describedby="basic-addon2"
                            v-model="search"
                            @input="showSearchItems = true"
                            ref="searchBox"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                Exact Match
                                <input
                                    type="checkbox"
                                    v-model="exactMatch"
                                    class="ml-2"
                                />
                            </div>
                        </div>
                    </div>
                    <ul
                        class="list-group"
                        style="overflow-y: scroll; max-height: 40vh;"
                        v-if="filteredList.length > 0 && showSearchItems == true"
                    >
                        <a
                            href="#"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            v-for="(item, index) in filteredList"
                            :key="index"
                            @click="
                selectSearchItem(item);
                showSearchItems = false;
              "
                            @mouseover="item.isMouseOveritem = true"
                            @mouseleave="item.isMouseOveritem = false"
                        >
              <span>
                <i class="fa fa-search mr-2" aria-hidden="true"></i
                >{{ item.name }}</span
              >

                            <span
                                class="badge badge-primary badge-pill"
                                v-show="item.isMouseOveritem"
                            >
                Click to Select</span
                            >
                        </a>
                    </ul>
                </div>

            </div>
            <div class="mt-4">
                Selected Item: <b>{{selectedItem}}</b>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            exactMatch: false,
            search: "",
            selectedItem:"",
            showSearchItems: false,
            isMouseOverList: false,
            searchItemList: [
                {
                    id: 1,
                    name: "AngularJs",
                    isMouseOveritem: false
                },
                {
                    id: 2,
                    name: "Node.Js",
                    isMouseOveritem: false
                },
                {
                    id: 3,
                    name: "Vue.js",
                    isMouseOveritem: false
                },
                {
                    id: 4,
                    name: "Bootstrap",
                    isMouseOveritem: false
                },
                {
                    id: 5,
                    name: "CodeIgniter",
                    isMouseOveritem: false
                },
                {
                    id: 6,
                    name: "ASP.NET",
                    isMouseOveritem: false
                },
                {
                    id: 7,
                    name: "ASP.NET Core",
                    isMouseOveritem: false
                }
            ]
        };
    },
    computed: {
        filteredList() {
            if (this.exactMatch)
                return this.searchItemList.filter((item) => {
                    return item.name.toLowerCase().startsWith(this.search.toLowerCase());
                });
            else
                return this.searchItemList.filter((item) => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase());
                });
        }
    },
    methods: {
        selectSearchItem(item) {
            this.search = item.name;
            this.selectedItem = item.name;
            this.showSearchItems = false;
        }
    }
};
</script>

