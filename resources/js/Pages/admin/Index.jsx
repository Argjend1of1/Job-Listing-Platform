import {InfiniteScroll, router, useForm, usePage} from "@inertiajs/react";
import {useEffect, useRef} from "react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import {RotatingLines} from "react-loader-spinner";
import AdminCard from "@/Pages/components/cards/AdminCard.jsx";

const Index = () => {
    const {admins, query} = usePage().props;
    const {data, setData} = useForm({
        q: query
    })
    const cancelToken = useRef(null);

    useEffect(() => {
        if(data.q === query) return;
        if(cancelToken.current) cancelToken.current.cancel();

        const delayDebounce = setTimeout(() => {
            router.get('/admins', {q: data.q}, {
                replace: true,
                preserveScroll: true,
                preserveState: true,
                reset: ['admins', 'query'],
                onCancelToken: (token) => cancelToken.current = token,
            })
        }, 500)

        return () => clearTimeout(delayDebounce);
    }, [data.q]);

    return (
        <>
            <section>
                {query === '' && (<PageHeading title={'Admins'}/>)}
                {query !== '' && (<PageHeading title={"Search results for '" + query + "'"}/>)}

                <Form>
                    <Input
                        name="q"
                        label={false}
                        placeholder="Search for admins..."
                        onChange={e => setData('q', e.target.value)}
                    />
                </Form>

                <InfiniteScroll data={'admins'}
                                loading={() => <div className={'flex justify-end my-3'}>
                                    <RotatingLines
                                        visible={true}
                                        height="40"
                                        width="40"
                                        color="grey"
                                        strokeWidth="5"
                                        animationDuration="0.75"
                                        ariaLabel="rotating-lines-loading"
                                        wrapperStyle={{}}
                                        wrapperClass=""
                                    />
                                </div>}
                >
                    {admins.data.length > 0 ? (
                        <div className="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mt-6">
                            {admins.data.map((admin) => (
                                <div key={admin.id}>
                                    <AdminCard admin={admin}/>
                                </div>
                            ) )}
                        </div>
                    ) : (
                        <p className="text-lg text-gray-500 mt-3">No Admin found.</p>
                    )}
                </InfiniteScroll>
            </section>
        </>
    )
}

export default Index;
