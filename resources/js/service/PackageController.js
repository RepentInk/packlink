export default {

    getCategory() {
        return axios.get('/get/category')
    },

    getLanguage() {
        return axios.get('/get/language')
    },

    getUserTutorial(number) {
        return axios.get('/get/tutorial/' + number);
    },

    getInstallation() {
        return axios.get('/get/installation')
    },

    getPackLanguage(id) {
        return axios.get('/get/pack/lang/' + id)
    },

    getPackInstallation(id) {
        return axios.get('/get/pack/install/' + id)
    },

    getComments(id, type) {
        return axios.get('/get/comment/' + id + '/' + type);
    },

    getAuthUserRate(user_id, pack_id) {
        return axios.get('/get/auth/rater/' + user_id + '/' + pack_id);
    },

    getRatings(id) {
        return axios.get('/get/rating/' + id);
    },

    getTitoRatings(id, type) {
        return axios.get('/get/tito/rating/' + id + '/' + type);
    },

    getAuthUserTitoRate(user_id, tito_id, type) {
        return axios.get('get/auth/tito/' + user_id + '/' + tito_id + '/' + type);
    },

    /**
     * Saving data into database
     */
    saveCategory(name) {
        let form = new FormData();
        form.append('name', name);
        return axios.post('/post/category', form);
    },

    saveLanguage(name) {
        let form = new FormData();
        form.append('name', name);
        return axios.post('/post/language', form)
    },

    saveInstallation(name) {
        let form = new FormData();
        form.append('name', name);
        return axios.post('/post/installation', form)
    },

    saveTutorial(id, title, name, url, lang, type, des) {
        let form = new FormData();
        form.append('id', id);
        form.append('title', title);
        form.append('name', name);
        form.append('url', url);
        form.append('lang', lang);
        form.append('type', type);
        form.append('des', des);
        return axios.post('/post/tutorial', form);
    },

    savePackage(id, name, link, command, description, procedure, cat_name, install_name, lang_name) {
        let form = new FormData();

        form.append('id', id)
        form.append('name', name);
        form.append('link', link);
        form.append('command', command);
        form.append('description', description);
        form.append('procedure', procedure);
        form.append('cat_id', cat_name);

        install_name.forEach(element => {
            form.append('install_id[]', element);
        });

        lang_name.forEach(element => {
            form.append('lang_id[]', element);
        });

        return axios.post('/post/package', form)
    },

    saveComments(id, comment_data, type) {
        let com = new FormData();

        com.append('pack_id', id);
        com.append('comment', comment_data);
        com.append('type', type)

        return axios.post('/post/comment', com)
    },

    saveRatings(pack_id, rating) {
        let form = new FormData();

        form.append('pack_id', pack_id);
        form.append('rating', rating);

        return axios.post('/post/rating', form);
    },

    saveTitoRatings(tito_id, rating, type) {
        let formData = new FormData();

        formData.append('tito_id', tito_id);
        formData.append('rating', rating);
        formData.append('type', type);

        return axios.post('/post/tito/rating', formData);
    },


    /**
     * Deleting routes
     */
    deleteTito(id) {
        return axios.delete('/delete/tutorial/' + id)
    },

    deleteInstall(id) {
        return axios.delete('/delete/pack/install/' + id)
    },

    deleteLanguage(id) {
        return axios.delete('/delete/pack/lang/' + id);
    },

    deletePack(id) {
        return axios.delete('/delete/package/' + id);
    },


    /**
     * Some basic functionality
     */
    getDifference(arr1, arr2) {
        let difference = arr1.filter(x => !arr2.includes(x));
        return difference;
    },

}