<template>
    <div class="custom-card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Converted Amount</th>
                        <th scope="col">Favourite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in getFavourites">
                        <td>{{ item.from.toUpperCase() }}</td>
                        <td>{{ item.to.toUpperCase() }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.amountTo }}</td>
                        <td v-if="isFavourite(item.from, item.to)"><a href="#" @click="removeFromFavourite(item.from, item.to)">Remove</a></td>
                        <td v-else><a href="#" @click="addToFavourite(item.from, item.to, item.amount)">Add</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        created() {

        },
        data() {
            return {
                db: JSON.parse(window.localStorage.getItem("favourites")).reverse() || []
            };
        },
        computed: {
            getFavourites() {
                return this.db;
            }
        },
        methods: {
            isFavourite(from, to) {
                let list = this.db.filter((obj) => {
                    return obj.from === from && obj.to === to;
                });

                return list.length === 1;
            },

            removeFromFavourite(from, to) {
                this.db = this.db.filter((obj) => {
                    return obj.from !== from && obj.to !== to;
                });

                window.localStorage.setItem("favourites", JSON.stringify(this.db));
            },

            addToFavourite(from, to, amount) {

                this.db.push({
                    "from": from,
                    "to": to,
                    "amount": amount,
                });

                window.localStorage.setItem("favourites", JSON.stringify(this.db));
            }
        }
    }
</script>
