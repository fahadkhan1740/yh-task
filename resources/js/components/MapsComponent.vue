<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-3 sm:col-span-2">
                    <label for="company_website" class="block text-sm font-medium text-gray-700">
                        Search
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input v-model="search" type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="First or Last Name">
                    </div>
                </div>
            </div>

            <div class="flex justify-center rounded-lg text-lg py-4" role="group">
                <button @click="filterMarkersUsingGender('')" class="bg-white text-blue-500 hover:bg-blue-500 hover:text-white border border-r-0 border-blue-500 rounded-l-lg px-4 py-2 mx-0 outline-none focus:shadow-outline">All</button>
                <button @click="filterMarkersUsingGender('Male')" class="bg-white text-blue-500 hover:bg-blue-500 hover:text-white border border-blue-500  px-4 py-2 mx-0 outline-none focus:shadow-outline">Male</button>
                <button @click="filterMarkersUsingGender('Female')" class="bg-white text-blue-500 hover:bg-blue-500 hover:text-white border border-l-0 border-blue-500 rounded-r-lg px-4 py-2 mx-0 outline-none focus:shadow-outline">Female</button>
            </div>

            <div id="map" style="position: initial; width: 100%; height: 480px">

            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>

            <!-- component -->
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        First Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gender
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lat/Lon
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="record in records" :key="record.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ record.id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ record.first_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ record.last_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                          {{ record.gender }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ record.lat }}/{{ record.lon }}
                                    </td>
                                </tr>

                                <!-- More rows... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                records: '',
                search: '',
                map: null,
                mapCenter: {lat: 0, lng: 0},
                gender: ''
            }
        },
        mounted() {
            console.log('Maps Component.');
            this.getRecords();
            this.initMap();
        },
        watch: {
            search: function (oldValue, newValue) {
                this.filterRecords(oldValue);
            }
        },
        methods: {
            initMap() {
                setTimeout(() => {
                    this.map = new google.maps.Map(document.getElementById('map'), {
                        center: this.mapCenter,
                        zoom: 1,
                        maxZoom: 20,
                        minZoom: 3,
                        zoomControl: true
                    })

                    this.mapMarkers();

                }, 2000)
            },
            getRecords() {
                axios.get('/api/records')
                    .then(res => {
                        this.records = res.data;
                    })
                    .catch(err => console.error(err));
            },
            filterRecords(value) {

                const filterItems = (arr, query) => {
                    return arr.filter((el) => {
                        if (el.first_name === undefined) {
                            return false;
                        }

                        if (el.first_name.toString().toLowerCase().indexOf(query.toLowerCase()) !== -1 ||
                            el.last_name.toString().toLowerCase().indexOf(query.toLowerCase()) !== -1
                        ) {
                            return true;
                        }
                    })
                }

                this.records = filterItems(this.records, this.search);

                if (value === '') {
                    this.getRecords();
                }
            },
            mapMarkers() {
                this.records.map((record) => {
                    let contentString = `
<div class="max-w-xs">
    <div class="bg-white shadow-xl rounded-lg py-3">
        <div class="p-2">
            <h3 class="text-center text-xl text-gray-900 font-medium leading-8">${record.first_name} ${record.last_name}</h3>
            <table class="text-xs my-3">
                <tbody><tr>
                    <td class="px-2 py-2 text-gray-500 font-semibold">Gender</td>
                    <td class="px-2 py-2">${record.gender}</td>
                </tr>
                <tr>
                    <td class="px-2 py-2 text-gray-500 font-semibold">Latitude</td>
                    <td class="px-2 py-2">${record.lat}</td>
                </tr>
                <tr>
                    <td class="px-2 py-2 text-gray-500 font-semibold">Longitude</td>
                    <td class="px-2 py-2">${record.lon}</td>
                </tr>
            </tbody></table>
        </div>
    </div>
</div>
                        `;

                    const infowindow = new google.maps.InfoWindow({
                        content: contentString,
                    });

                    let url = "http://maps.google.com/mapfiles/ms/icons/";

                    let color = record.gender === 'Male' ? 'blue' : 'pink';
                    url += color + "-dot.png";

                    let marker = new google.maps.Marker({
                        position: new google.maps.LatLng(record.lat, record.lon),
                        map: this.map,
                        icon: {
                            url: url
                        }
                    });

                    marker.addListener("click", () => {
                        infowindow.open(this.map, marker);
                    });
                })

            },
            filterMarkersUsingGender(gender) {

                setTimeout(() => this.getRecords(), 3000);

                if (gender === '') {
                    this.initMap();
                    return true;
                }

                this.gender = gender;

                let filterItems = (arr) => {
                    return arr.filter((el) => {
                        if (el.first_name === undefined) {
                            return false;
                        }

                        if (el.gender.toString() === this.gender) {
                            return true;
                        }
                    })
                }

                this.records = filterItems(this.records, this.search);
                console.warn(this.records);
                this.initMap();

            }
        }
    }
</script>
