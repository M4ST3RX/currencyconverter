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
                    <tr v-for="(item, index) in getHistory">
                        <td>{{ item.from.toUpperCase() }}</td>
                        <td>{{ item.to.toUpperCase() }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.amountTo }}</td>
                        <td v-if="isFavourite(item.from, item.to, item.amount, item.amountTo)"><a href="#" @click="removeFromFavourite(item.from, item.to)">Remove</a></td>
                        <td v-else><a href="#" @click="addToFavourite(item.from, item.to, item.amount, item.amountTo)">Add</a></td>
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
                db: JSON.parse(window.localStorage.getItem("favourites")) || [],
                historyDb: JSON.parse(window.localStorage.getItem("history")).reverse() || []
            };
        },
        computed: {
            getHistory() {
                return this.historyDb;
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
                    return obj.from === from && obj.to === to;
                });

                window.localStorage.setItem("favourites", JSON.stringify(this.db));
            },

            addToFavourite(from, to, amount, amountTo) {
                let found = false;

                // Check if object exists in favourites list
                this.db.forEach((data, index) => {
                    if(data.from === from && data.to === to) {
                        this.db[index] = {
                            "from": from,
                            "to": to,
                            "amount": amount,
                            "amountTo": amountTo
                        };
                        found = true;
                    }
                });

                // If not add it
                if(!found) {
                    this.db.push({
                        "from": from,
                        "to": to,
                        "amount": amount,
                        "amountTo": amountTo
                    });
                }

                // Save the list
                window.localStorage.setItem("favourites", JSON.stringify(this.db));
            }
        }
    }
</script>
