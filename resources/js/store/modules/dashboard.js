const state = {
    // loading_component: false,
    date_filter: {
        from: new Date(new Date().setDate(new Date().getDate()-30)).toLocaleDateString('en-CA'),
        to: new Date().toLocaleDateString('en-CA')
    },
    chart_category: {
        chart1: 'Age',
        chart2: 'Severity'
    }
};

const getters = {
    // loading_component: state => state.loading_component,
    date_filter: state => state.date_filter,
    chart_category: state => state.chart_category
};

const actions = {
};

const mutations = {
    // SET_LOADING_COMPONENT: (state, status) => {
    //     state.loading_component = status
    // }
    SET_DATE_FILTER: (state, dates) => {
        state.date_filter = dates
    },
    SET_CHART_CATEGORY: (state, categ) => {
        state.chart_category = categ
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};