import {useForm} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import QueryInput from "@/Pages/components/forms/QueryInput.jsx";
import {Fragment, useEffect, useRef} from "react";
import {queryLogic} from "@/reusableFunctions/queryLogic.js";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";
import EmployerCard from "@/Pages/components/cards/EmployerCard.jsx";
import EmployerCardWide from "@/Pages/components/cards/EmployerCardWide.jsx";

const Index = ({employers, query}) => {
    const {data, setData} = useForm({q: query})
    const cancelToken = useRef(null);

    useEffect(() => {
        const delayDebounce = queryLogic(
            '/employers', data, query, cancelToken, 'employers'
        )

        return () => clearTimeout(delayDebounce);
    }, [data.q]);

    return (
       <>
           <section>
               <PageHeading title={
                   query === ''
                       ? 'Employers'
                       : `Search Results for '${query}'`
               } />

               <Form>
                   <QueryInput
                       setData={setData}
                       data={data}
                       placeholder={'Search For Employer...'}
                   />
               </Form>

               {employers.data.length > 0 ? (
                   <InfiniteScrolling data={'employers'}>
                       {employers.data.map((employer) => (
                           <Fragment key={employer.id}>
                               <EmployerCardWide employer={employer} />
                           </Fragment>
                       ))}
                   </InfiniteScrolling>
               ) : (
                   <p className="text-lg text-gray-500 mt-3">No employer found.</p>
               )}


           </section>
       </>
    )
}

export default Index;
