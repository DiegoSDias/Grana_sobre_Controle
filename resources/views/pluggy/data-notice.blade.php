<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 px-4 py-8 sm:px-6 sm:py-12">
        <div class="mx-auto max-w-4xl">
            <header class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M5.1 19h13.8c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.37 16c-.77 1.33.19 3 1.73 3z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">Transparência dos dados</p>
                    <h1 class="mt-2 text-3xl font-light tracking-tight text-slate-900 sm:text-4xl">Sobre as movimentações importadas</h1>
                    <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Entenda como funcionam os dados recebidos pela Pluggy e por que a sua conferência faz diferença.</p>
                </div>
                <a href="{{ route('pluggy.connections') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Ver conexões</a>
            </header>

            <section class="overflow-hidden rounded-3xl bg-slate-900 p-6 text-white shadow-xl shadow-slate-200 sm:p-8">
                <div class="max-w-3xl">
                    <p class="text-sm font-medium text-blue-200">Leia antes de usar a importação</p>
                    <h2 class="mt-2 text-2xl font-light sm:text-3xl">Os dados importados facilitam o controle, mas não substituem a conferência do seu extrato.</h2>
                    <p class="mt-4 leading-7 text-slate-300">As informações são fornecidas pela sua instituição financeira por meio da Pluggy. Embora trabalhemos para organizar cada lançamento da melhor forma, descrições, categorias, valores e tipos de movimentação podem chegar incompletos, atrasados ou interpretados de maneira diferente da situação real.</p>
                </div>
            </section>

            <section class="mt-6 rounded-3xl border border-amber-200 bg-amber-50 p-6 sm:p-8">
                <div class="flex gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-amber-950">O que você precisa fazer</h2>
                        <p class="mt-2 leading-7 text-amber-900">Revise periodicamente as movimentações importadas e ajuste ou exclua o que não representa uma receita ou despesa real. Em caso de divergência, considere o seu extrato bancário e os comprovantes como referência.</p>
                    </div>
                </div>
            </section>

            <section class="mt-8">
                <h2 class="text-xl font-semibold text-slate-900">Situações que podem exigir atenção</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 12-4-4m4 4 4-4m6-4v12m0-12 4 4m-4-4-4 4" /></svg></div>
                        <h3 class="mt-4 font-semibold text-slate-900">Transferências entre suas contas</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Uma transferência pode aparecer como saída em uma conta e entrada em outra. Ela não é, por si só, uma nova despesa nem uma nova receita.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11a4 4 0 010 8H9m-6-8 4-4m-4 4 4 4" /></svg></div>
                        <h3 class="mt-4 font-semibold text-slate-900">Estornos, devoluções e cancelamentos</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">O reembolso de uma compra pode ser importado como entrada. Quando ele apenas desfaz uma compra, verifique se os dois lançamentos devem ser desconsiderados no seu controle.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.1 19h13.8c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.37 16c-.77 1.33.19 3 1.73 3z" /></svg></div>
                        <h3 class="mt-4 font-semibold text-slate-900">Duplicidades e lançamentos pendentes</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Algumas instituições podem enviar lançamentos pendentes e, depois, o lançamento confirmado. Datas ou valores também podem ser atualizados após a compra.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01" /></svg></div>
                        <h3 class="mt-4 font-semibold text-slate-900">Descrições e categorias</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">O nome do estabelecimento pode ser abreviado ou diferente do que aparece no comprovante. A categoria automática é uma sugestão e pode precisar de correção.</p>
                    </article>
                </div>
            </section>

            <section class="mt-8 rounded-3xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-xl font-semibold text-slate-900">Como manter seus dados mais fiéis à realidade</h2>
                <ol class="mt-5 space-y-4 text-slate-700">
                    <li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">1</span><span class="pt-0.5">Compare os lançamentos importados com o extrato da instituição financeira.</span></li>
                    <li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">2</span><span class="pt-0.5">Edite, exclua ou crie regras para movimentações que não devem entrar nos seus totais.</span></li>
                    <li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">3</span><span class="pt-0.5">Revise o período antes de tomar decisões financeiras com base nos relatórios.</span></li>
                </ol>
                <div class="mt-6 rounded-2xl bg-blue-50 p-4 text-sm leading-6 text-blue-900">Ao manter uma conexão ativa, você reconhece que os dados importados são informativos e se compromete a conferir movimentações relevantes antes de usá-las como base para decisões financeiras.</div>
            </section>
        </div>
    </div>
</x-app-layout>
