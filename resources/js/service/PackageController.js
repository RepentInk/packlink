export default {

    /**
     * Getting data from routes
     */
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