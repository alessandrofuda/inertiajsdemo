<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
    <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a class="text-indigo-500 underline hover:text-orange-600" href="https://inertiajs.com">Inertia.js</a> works.</p>
    <div class="mb-8 flex">
      <inertia-link class="btn-indigo" href="/500">500 error</inertia-link>
      <inertia-link class="btn-indigo ml-1" href="/404">404 error</inertia-link>
    </div>
    <p class="leading-normal">👆 These links are intended to be broken to illustrate how error handling works with Inertia.js.</p>

    <h2 class="mb-8 mt-12 font-bold text-2xl">Add Organizations via email .csv attachments.<br>Parsing csv email attachment via Laravel and insert data in Db</h2>
    <div class="parsing-email">
      <ul class="list-decimal list-inside mt-4">
        <li class="mb-2">Send email to: "<em>{{ mailgunTestEmail }}</em>" with .csv attachment.</li>
        <li class="mb-2">Mailgun receive and routing the email to Laravel endpoint (in dev environment use ngrok to forward to localhost)</li>
        <li class="mb-2">Laravel receive notification from mailgun onto its api route and parse email payload</li>
        <li class="mb-2">Laravel make auth API call to attachment url to get attachment content</li>
        <li class="mb-2">Laravel parse and return csv attachment content and insert this information into db</li>
      </ul>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
  props: {
    mailgunTestEmail: String,
  },
}
</script>
