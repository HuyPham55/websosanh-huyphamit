const fetchAsideNews = async function() {
    let arrItems = []
    await axios.post('/api/fetch-aside-news')
        .then(res => {
            let data = res.data
            arrItems = data.data.data;
        })
    return arrItems
}

export {
    fetchAsideNews
}
