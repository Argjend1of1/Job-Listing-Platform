import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import {useForm} from "@inertiajs/react";
import {Fragment, useEffect, useRef} from "react";
import {queryLogic} from "@/reusableFunctions/queryLogic.js";
import QueryInput from "@/Pages/components/forms/QueryInput.jsx";
import EmployerCard from "@/Pages/components/cards/EmployerCard.jsx";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";

const Index = ({employers, query}) => {
    const {data, setData} = useForm({
        q: query
    })
    const cancelToken = useRef(null);

    useEffect(() => {
        const delayDebounce = queryLogic(
            '/companies', data, query, cancelToken, 'employers'
        )

        return () => clearTimeout(delayDebounce);
    }, [data.q]);

    return (
        <>
            <section className={'my-8'}>
                {query !== '' && (<PageHeading title={`Search Results for '${query}'`}/> )}
                {query === '' && (<PageHeading title={'Companies'}/> )}

                <Form>
                    <QueryInput
                        placeholder={"Search For Company..."}
                        data={data}
                        setData={setData}
                    />
                </Form>
            </section>

            <InfiniteScrolling data={'employers'}>
                {employers.data.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        {employers.data.map((employer) => (
                            <Fragment key={employer.id}>
                                <EmployerCard employer={employer}/>
                            </Fragment>
                        ))}
                    </div>
                ) : (
                    <p className="text-lg text-gray-500 mt-3">No company found.</p>
                )}
            </InfiniteScrolling>
        </>
    )
}

export default Index;
