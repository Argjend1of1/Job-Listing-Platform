import {useForm, usePage} from "@inertiajs/react";
import {useEffect, useRef} from "react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import AdminCard from "@/Pages/components/cards/AdminCard.jsx";
import QueryInput from "@/Pages/components/forms/QueryInput.jsx";
import {queryLogic} from "@/reusableFunctions/queryLogic.js";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";

const Index = () => {
    const {admins, query} = usePage().props;
    const {data, setData} = useForm({
        q: query
    })
    const cancelToken = useRef(null);

    useEffect(() => {
        const delayDebounce = queryLogic(
            '/admins', data, query, cancelToken, 'admins'
        )

        return () => clearTimeout(delayDebounce);
    }, [data.q]);

    return (
        <>
            <section>
                {query === '' && (<PageHeading title={'Admins'}/>)}
                {query !== '' && (<PageHeading title={"Search results for '" + query + "'"}/>)}

                <Form>
                    <QueryInput
                        data={data}
                        setData={setData}
                        placeholder={"Search for admins..."}
                    />
                </Form>
            </section>

            <InfiniteScrolling data={data}>
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
            </InfiniteScrolling>
        </>
    )
}

export default Index;
