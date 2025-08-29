<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import axiosInstance from "@/api"; // central axios instance
import PrimaryBtn from "@/components/Dashboard/Buttons/PrimaryBtn.vue";
import Logo from "@/components/Logo.vue";

const email = ref("");
const password = ref("");
const showPassword = ref(false);
const loading = ref(false);

const toast = useToast();
const router = useRouter();

// Check if already logged in
onMounted(async () => {
    try {
        const res = await axiosInstance.get("/auth/check", { withCredentials: true });
        if (res.data.loggedIn) {
            router.replace("/dashboard/"); // prevent going back to login
        }
    } catch (e) {
        // Stay on login if check fails
    }
});

async function handleLogin() {
    if (!email.value || !password.value) {
        toast.error("Email and password are required");
        return;
    }

    loading.value = true;
    try {
        const response = await axiosInstance.post(
            "/auth/login",
            { email: email.value, password: password.value },
            { withCredentials: true }
        );

        if (response.data.success) {
            toast.success("Login successful");
            router.replace("/dashboard/");
        } else {
            toast.error(response.data.error || "Invalid credentials");
        }
    } catch (error) {
        toast.error(error.response?.data?.error || "Login failed. Please try again.");
    } finally {
        loading.value = false;
    }
}

function toggleShowPassword() {
    showPassword.value = !showPassword.value;
}
</script>


<template>
    <div class="flex flex-col justify-center items-center h-screen text-text-main m-5">
        <div class="bg-horizontal-line">
            <Logo />
        </div>
        <div class="border border-horizontal-line/20 p-4 m-3 rounded-lg  w-full max-w-md">
            <h1 class="text-center text-3xl font-bold m-2">Login</h1>
            <form @submit.prevent="handleLogin" class="flex flex-col ">
                <input type="email" v-model="email" placeholder="Email"
                    class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line" required>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="Password"
                        class="bg-primary/20 px-4 py-3 my-2 rounded-lg text-center outline-horizontal-line w-full"
                        required>
                    <button type="button" @click="toggleShowPassword"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-sm text-horizontal-line hover:text-text-main focus:outline-none">
                        <div v-if="showPassword">
                            <span class="material-symbols-outlined">
                                visibility
                            </span>
                        </div>
                        <div v-else>
                            <span class="material-symbols-outlined">
                                visibility_off
                            </span>
                        </div>
                    </button>
                </div>
                <PrimaryBtn type="submit" name="Login" />
            </form>
        </div>
        <p>
            Don't have an account? <router-link to="/register"
                class="text-horizontal-line hover:underline">Register</router-link>
        </p>
    </div>
</template>
