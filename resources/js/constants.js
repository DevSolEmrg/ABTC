export function drawerSize(size) {
    if (size < 960) {
        return 100
    } else if (size > 960 && size < 1264) {
        return 80
    } else {
        return 75
    }
}

export function dialogSize(size) {
    if (size < 960) {
        return 98
    } else if (size > 960 && size < 1264) {
        return 60
    } else {
        return 30
    }
}

export function buildDate(param_date) {
    let date = new Date(param_date).toLocaleDateString().split('/'), /*yr*/ yr = date[2], /*mon*/ mon = date[0] < 10 ? `0${date[0]}` : date[0], /*day*/ day = date[1] < 10 ? `0${date[1]}` : date[1]
    return `${yr}-${mon}-${day}`
}

export function calAge(dateString) {
    var birthday = +new Date(dateString);
    return ~~((Date.now() - birthday) / (31557600000));
}