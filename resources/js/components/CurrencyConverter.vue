<template>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-2">
                    <select @change="currencyChange" v-model="fromCurrency" class="form-control currency-option">
                        <option v-for="currency in currencies" :value="currency.currency">{{ currency.name }}</option>
                    </select>
                    <input type="number" @focusout="saveHistory" @input="calculateOutputNumber" v-model="inputNumber" :currency="fromCurrency" class="form-control" />
                </div>
                <div class="col-md-6">
                    <select @change="currencyChange" v-model="toCurrency" class="form-control currency-option">
                        <option v-for="currency in currencies" :value="currency.currency">{{ currency.name }}</option>
                    </select>
                    <input type="number" v-model="outputNumber" :currency="toCurrency" class="form-control font-weight-bold" disabled />
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div>
                    <a v-if="favourite" href="#" style="color: #38a638;" @click="markAsFavourite">Edit Favourite</a>
                    <a v-else href="#" id="markAsFav" @click="markAsFavourite">Mark As Favourite</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            axios.get('/api/currencies').then(response => {
                this.currencies = response.data;
                this.favourite = this.isFavourite();
            });

            if(!window.localStorage.getItem("favourites")) {
                window.localStorage.setItem("favourites", JSON.stringify([]));
            }

            if(!window.localStorage.getItem("history")) {
                window.localStorage.setItem("history", JSON.stringify([]));
            }
        },
        data() {
            return {
                currencies: [],
                inputNumber: 0,
                outputNumber: 0,
                fromCurrency: "gbp",
                toCurrency: "usd",
                db: JSON.parse(window.localStorage.getItem("favourites")) || [],
                historyDb: JSON.parse(window.localStorage.getItem("history")) || [],
                favourite: false
            };
        },
        methods: {
            calculateOutputNumber() {
                // Find currency object converting from
                let fromCurr = this.currencies.filter(obj => {
                    return obj.currency === this.fromCurrency;
                })[0];

                // Find currency object converting to
                let toCurr = this.currencies.filter(obj => {
                    return obj.currency === this.toCurrency;
                })[0];

                // Check if input is not empty and currency objects are not undefined
                if(!this.inputNumber || this.inputNumber === "" || this.inputNumber == null || fromCurr === undefined || toCurr === undefined || fromCurr == null ||toCurr == null || isNaN(this.inputNumber)) {
                    this.outputNumber = 0;
                    return;
                }

                // If currency converting from and to are the same set output number to input number
                if(this.fromCurrency === this.toCurrency) {
                    this.outputNumber = this.inputNumber;
                    return;
                }

                // Calculate the converted amount - currency from -> GBP -> currency to
                let exchange = parseFloat(this.inputNumber)*fromCurr.inverseRate*toCurr.exchangeRate;

                // Set output number to formatted amount
                this.outputNumber = Number(exchange).toFixed(2);
            },

            currencyChange() {
                this.calculateOutputNumber();

                this.favourite = this.isFavourite();

            },

            isFavourite() {
                let list = this.db.filter((obj) => {
                    return obj.from === this.fromCurrency && obj.to === this.toCurrency;
                });

                return list.length === 1;
            },

            saveHistory() {
                this.historyDb.push({
                    "from": this.fromCurrency,
                    "to": this.toCurrency,
                    "amount": this.inputNumber,
                    "amountTo": this.outputNumber
                });
                window.localStorage.setItem("history", JSON.stringify(this.historyDb));
            },

            markAsFavourite() {
                let found = false;

                // Check if object exists in favourites list
                this.db.forEach((data, index) => {
                    if(data.from === this.fromCurrency && data.to === this.toCurrency) {
                        this.db[index] = {
                            "from": this.fromCurrency,
                            "to": this.toCurrency,
                            "amount": this.inputNumber,
                            "amountTo": this.outputNumber
                        };
                        found = true;
                    }
                });

                // If not add it
                if(!found) {
                    this.db.push({
                        "from": this.fromCurrency,
                        "to": this.toCurrency,
                        "amount": this.inputNumber,
                        "amountTo": this.outputNumber
                    });
                }

                // Save favourites list and trigger alert message
                window.localStorage.setItem("favourites", JSON.stringify(this.db));
                this.favourite = true;
                this.$root.$emit('addAlert');
            }
        }
    }
</script>
