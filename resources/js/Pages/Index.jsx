import {Link, usePage} from "@inertiajs/react";
import JobCard from "./components/cards/JobCard.jsx";
import Heading from "./components/body/Heading.jsx";
import Tag from "./components/body/Tag.jsx";

const Index = () => {
    const {topJobs, otherJobs, tags, auth} = usePage().props;

   return (
       <div className="space-y-10">
           {auth.user &&
               <h1 className="font-bold text-3xl/10 text-center">
                    Welcome {auth.user.name}, Let's Find Your Next Job
               </h1>
           }
           {!auth.user &&
               <h1 className="font-bold text-3xl/10 text-center">
                   Welcome, Let's Find Your Next Job
               </h1>
           }

           <section className="pt-3">
               <Heading title="Top Jobs"/>

               <div className="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">
                   {topJobs &&
                        topJobs.map((job) => (
                            <div key={job.id} className="min-w-[300px]">
                                <JobCard job={job}/>
                            </div>
                        ))
                   }
               </div>
               <Link
                   href="/jobs/top"
                   className="text-gray-400 hover:text-white flex justify-end"
               >
                   See more
               </Link>

           </section>

           <section>
               <Heading title="Most Searched Tags"/>
               <div className="mt-6 flex flex-wrap gap-2">
                   {tags.data.map((tag) => (
                       <div key={tag.id}>
                           <Tag tag={tag} className={"text-[20px] px-3.5 py-1.5"}/>
                       </div>
                   ))}
               </div>

           </section>

           <section>
               <Heading title="More Jobs"/>
               <div className="flex overflow-x-auto space-x-6 px-4 py-2 scrollbar-custom mb-2">
                   {otherJobs &&
                       otherJobs.map((job) => (
                           <div key={job.id} className={"min-w-[300px]"}>
                               <JobCard job={job}/>
                           </div>
                       ))
                   }
               </div>
               <a href="/jobs/more" className="text-gray-400 hover:text-white flex justify-end">See more</a>
           </section>
       </div>
   )
}

export default Index
