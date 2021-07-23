<template>
    <div class = "container  pt-16 h-screen flex flex-col items-end gap-6">
        <vs-table>
            <template #thead>
                <vs-tr>
                    <vs-th @click = "users = $vs.sortData($event ,users, 'id')">
                        Id
                    </vs-th>
                    <vs-th>
                        Username
                    </vs-th>
                    <vs-th>
                        Email
                    </vs-th>
                    <vs-th class = "w-60"
                           @click = "users = $vs.sortData($event ,users, 'role')">
                        Role
                    </vs-th>
                    <vs-th class = "w-80"
                           sort
                           @click = "users = $vs.sortData($event ,users, 'created_at')">
                        Date of registration
                    </vs-th>
                    <vs-th>
                        Save
                    </vs-th>

                </vs-tr>
            </template>
            <template #tbody>
                <vs-tr
                    :key = "i"
                    v-for = "(user, i) in $vs.getPage(users, page, max)"

                >
                    <vs-td>
                        {{ user.id }}
                    </vs-td>
                    <vs-td>
                        {{ user.name }}
                    </vs-td>
                    <vs-td>
                        {{ user.email }}
                    </vs-td>
                    <vs-td>
                        <vs-select label = "Select"
                                   v-model = "user.role">
                            <vs-option
                                label = "User"
                                value = "0"
                            >
                                User
                            </vs-option>
                            <vs-option
                                label = "Admin"
                                value = "1"
                            >
                                Admin
                            </vs-option>
                            <vs-option
                                label = "SuperAdmin"
                                value = "2"
                            >
                                SuperAdmin
                            </vs-option>
                        </vs-select>
                    </vs-td>
                    <vs-td>
                        {{ new Date(user.created_at).toGMTString() }}
                    </vs-td>
                    <vs-td>
                        <a href = ""
                           :data-id = "user.id"
                           :data-role = "user.role"
                           @click.prevent = "saveUser($event) "
                           class = "btn bg-primary text-blue-50 ">Save
                        </a>
                    </vs-td>
                </vs-tr>
            </template>
            <template #footer>
                <vs-pagination v-model = "page"
                               :length = "$vs.getLength(users, max)" />
            </template>
        </vs-table>

    </div>
</template>

<script>
export default {
    name: "Users",
    data() {
        return {
            users: [],
            page: 1,
            max: 10,
        }
    },
    methods: {
        saveUser(event) {
            const loading = this.$vs.loading({color: '#48CAE4'});

            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.put('/api/users', {
                    id: event.target.dataset.id,
                    role: event.target.dataset.role,
                }).then((response) => {
                    if (response.status === 200) {
                        this.users = this.users.map((item) => {

                            if (item.id === response.data.id) {
                                item = response.data;
                            }
                            return item;
                        });
                    }
                    this.openNotification('success', 'User updated.', 'top-right');
                    loading.close();
                }).catch(error => {
                    loading.close();
                    if (error.response.status === 403 || error.response.status === 401) {
                        this.openNotification('danger', 'You don\'t have permission on this action', 'top-right',);
                    } else if (error.response.status === 400) {
                        this.openNotification('danger', error.response.data, 'top-right',);
                    } else {
                        this.openNotification('danger', 'Something goes wrong, try later.', 'top-right',);
                    }

                    console.log(error)
                });
            })
        },
        openNotification(color, title, position = null) {
            const not = this.$vs.notification({
                color,
                title,
                position,

            });
            not.close()
        },
    },
    beforeCreate: function () {

        const loading = this.$vs.loading({color: '#48CAE4'});

        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.get('/api/users').then((response) => {
                if (response.status === 200) {
                    this.users = response.data;

                }
                loading.close();
            }).catch(error => {
                loading.close();
                if (error.response.status === 403 || error.response.status === 401) {
                    this.openNotification('danger', 'You don\'t have permission on this action', 'top-right',);
                } else if (error.response.status === 400) {
                    this.openNotification('danger', error.response.data, 'top-right',);
                } else {
                    this.openNotification('danger', 'Something goes wrong, try later.', 'top-right',);
                }

                console.log(error)
            });
        })
    }
}
</script>

<style scoped>

</style>
