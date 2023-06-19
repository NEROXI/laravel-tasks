import { createApp } from 'vue';
import axios from 'axios';
import moment from "moment";
import $ from 'jquery'

const app = createApp({
    data() {
        return {
            reviews: [],
            from: 1,
            to: 10,
            totalCount: 0,
            pagesCount: 0,
            currentPage: 1
        };
    },
    mounted() {
        this.fetchReviews(1);
        this.fetchCount();
    },
    methods: {
        fetchReviews(page) {
            if(page == this.page) return;
            const resultsPerPage = 10;
            const start = (page - 1) * resultsPerPage + 1;
            const end = page * resultsPerPage;

            axios.get(`/api/review/getAll?from=${start}&to=${end}`)
                .then(response => {
                    if (response.data.status === 'success') {
                        this.reviews = response.data.data;
                        this.from = start;
                        this.to = end;
                        this.currentPage = page;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchCount() {
            axios.get('/api/review/getCount')
                .then(response => {
                    if (response.data.status === 'success') {
                        this.totalCount = response.data.data.count;
                        if(this.totalCount < 10) {
                            this.to = this.totalCount;
                            this.pagesCount = 1;
                        }
                        else {
                            this.pagesCount = parseInt(Math.ceil(this.totalCount / 10));
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        submitEditForm(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            axios.post(event.target.action, formData)
                .then(response => {
                    if(response.data.status == 'success') {
                        showAlert('success', 'Review successfully updated!');
                    }
                    else {
                        const errorMessages = Object.values(response.data.errors).flat().join(' ');
                        showAlert('error', errorMessages);
                    }
                })
                .catch(error => {
                    const errorMessages = Object.values(error.response.data.errors).flat().join(' ');
                    showAlert('error', errorMessages);
                });
        },
        submitCreateForm(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            axios.post(event.target.action, formData)
                .then(response => {
                    if(response.data.status == 'success') {
                        showAlert('success', 'Review successfully created!');
                    }
                    else {
                        const errorMessages = Object.values(response.data.errors).flat().join(' ');
                        showAlert('error', errorMessages);
                    }
                })
                .catch(error => {
                    const errorMessages = Object.values(error.response.data.errors).flat().join(' ');
                    showAlert('error', errorMessages);
                });
        },
        goToPage(page) {
            this.fetchReviews(page);
        },
        goToPreviousPage() {
            if(this.currentPage == 1) return;
            this.fetchReviews(this.currentPage - 1);
        },
        goToNextPage() {
            if(this.to >= this.totalCount) return;
            this.fetchReviews(this.currentPage + 1);
        },
        formatDate(dateTime) {
            if(parseInt(Math.ceil(this.currentPage * 10) > this.totalCount)) return;
            return moment(dateTime).format('Y-MM-DD H:mm');
        },
    }
});

const showAlert = (type, text) => {
    const alertBlock = $(`#${type}-alert`);
    alertBlock.removeClass('hidden');
    alertBlock.removeClass('opacity-0');
    alertBlock.addClass('opacity-100');
    alertBlock.find('.alert-text').text(text);
    setTimeout(() => {
        alertBlock.removeClass('opacity-100');
        alertBlock.addClass('opacity-0');
        alertBlock.addClass('hidden');
    }, 5000);
}

app.mount('#app');


