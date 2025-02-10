export const defineTitle = (title) => {
    document.title =title + ' | FINANCIERA EMPRENDER'
}

export const getdataParamsPagination = ( data) => {
    return "?page=" + data.page + "&paginacion="+ data.paginacion + "&buscar=" +data.buscar;
}

export const getConfigHeader = () => {

    if(localStorage.getItem('token-api'))
    {
        let decode = JSON.parse(localStorage.getItem('token-api')||"")
        let token = decode.token

        return {
            headers:{
                'Authorization': 'JWT ' + token
            }
        }
    }
}


export const getConfigHeaderPost = () => {
    if(localStorage.getItem('token-api'))
    {
        let decode = JSON.parse(localStorage.getItem('token-api')||"")
        let token = decode.access

        return {
            headers:{
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'JWT ' + token
            }
        }
    }
}