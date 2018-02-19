export default class Form {
    constructor(data = {}) {
        this.originalData = data;
        this.data = data;

        for (let key in this.data) {
            this[key] = this.data[key];
        }
    }

    reset() {
        this.data = this.originalData;

        for (let key in this.data) {
            this[key] = this.data[key];
        }
    }

    get() {
        let data = {};

        for (let key in this.originalData) {
            data[key] = this[key];
        }

        return data;
    }
}
