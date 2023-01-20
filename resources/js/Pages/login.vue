<template>
    <div>
        <div class="h-screen m-auto flex flex-col justify-center max-w-xs">
            <div class="w-full flex justify-center flex-row">
                <img class="h-32" src="pictures/logo.png" alt="Logo HelpDesk" />
            </div>
            <!-- bg-white -->
            <form
                @submit.prevent="form.post($route('login'))"
                class="bg-gray-50 shadow-md rounded px-8 pt-6 pb-8 mb-4"
            >
                <div class="mb-4">
                    <label
                        class="block text-gray-700 text-sm font-bold mb-2"
                        for="username"
                    >
                        Utilisateur
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="username"
                        type="email"
                        v-model="form.email"
                        placeholder="Mail"
                    />
                    <b v-if="form.errors.email" class="text-red-500">{{
                        form.errors.email
                    }}</b>
                </div>

                <div class="mb-6">
                    <label
                        class="block text-gray-700 text-sm font-bold mb-2"
                        for="password"
                    >
                        Mot de passe
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password"
                        type="password"
                        v-model="form.password"
                        placeholder="*********"
                    />
                    <b v-if="form.errors.password" class="text-red-500">{{
                        form.errors.password
                    }}</b>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit"
                    >
                        Connexion
                    </button>
                </div>
            </form>

            <p class="text-center text-gray-500 text-xs">
                &copy;2022 HelpDesk. Tous droits réservés.
            </p>
            <!-- <p>
                jones@gmail.com: Responsable <br>
                chaplin@gmail.com : Demandeur <br>
                sanchez@gmail.com&nilson@gmail.com : Operateur
            </p> -->
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    components: {},
    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
            }),
        };
    },
};
</script>
