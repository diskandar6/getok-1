<div class="container z-depth-1 my-5 py-5 px-4 px-lg-0">

  <!-- Section -->
  <section>
    
    <style>
      .timeline {
        position: relative;
        list-style: none;
        padding: 1rem 0;
        margin: 0;
      }

      .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        margin-left: -1px;
        background-color: #50a1ff;
      }

      .timeline-element {
        position: relative;
        width: 50%;
        padding: 1rem 0;
        padding-right: 2.5rem;
        text-align: right;
      }

      .timeline-element::before {
        content: '';
        position: absolute;
        right: -8px;
        top: 1.35rem;
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #50a1ff;
        background-color: #fff;
      }

      .timeline-element:nth-child(even)::before {
        right: auto;
        left: -8px;
      }

      .timeline-element:nth-child(even) {
        margin-left: 50%;
        padding-left: 2.5rem;
        padding-right: 0;
        text-align: left;
      }

      @media (max-width: 767.98px) {
        .timeline::before {
          left: 8px;
        }
      }

      @media (max-width: 767.98px) {
        .timeline-element {
          width: 100%;
          text-align: left;
          padding-left: 2.5rem;
          padding-right: 0;
        }
      }

      @media (max-width: 767.98px) {
        .timeline-element::before {
          top: 1.25rem;
          left: 1px;
        }
      }

      @media (max-width: 767.98px) {
        .timeline-element:nth-child(even) {
          margin-left: 0rem;
        }
      }

      @media (max-width: 767.98px) {
        .timeline-element {
          width: 100%;
          text-align: left;
          padding-left: 2.5rem;
          padding-right: 0;
        }
      }

      @media (max-width: 767.98px) {
        .timeline-element:nth-child(even)::before {
          left: 1px;
        }
      }

      @media (max-width: 767.98px) {
        .timeline-element::before {
          top: 1.25rem;
        }
      }
    </style>
    
    <h3 class="font-weight-bold text-center dark-grey-text pb-2">Our History</h3>
    <hr class="w-header my-4">
    <p class="lead text-center text-muted pt-2 mb-5">MDB founded to help startups, and it still shapes the way we work today.</p>
    
    <div class="row">
      <div class="col-lg-8 mx-auto">

        <ol class="timeline">
          <li class="timeline-element">
            <h5 class="font-weight-bold dark-grey-text mb-3">Launched our website</h5>
            <p class="grey-text font-small"><time datetime="2017-02-08">08 Feb 2017</time></p>
            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda ullam adipisci reiciendis porro natus laudantium similique. 
              Explicabo amet ipsum fugiat aliquam alias.</p>
          </li>

          <li class="timeline-element">
            <h5 class="font-weight-bold dark-grey-text mb-3">Got the first 100 users</h5>
            <p class="grey-text font-small"><time datetime="2017-08-17">17 Aug 2017</time></p>
            <p><img class="img-fluid z-depth-1-half rounded" src="https://mdbootstrap.com/img/Photos/Horizontal/Work/12-col/img%20(6).jpg" alt="..."></p>
            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda ullam adipisci reiciendis porro natus laudantium similique. 
              Explicabo amet ipsum fugiat aliquam alias.</p>
          </li>

          <li class="timeline-element">
            <h5 class="font-weight-bold dark-grey-text mb-3">Raised $1.4 million in seed funding</h5>
            <p class="grey-text font-small"><time datetime="2018-03-26">26 Mar 2019</time></p>
            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda ullam adipisci reiciendis porro natus laudantium similique. 
              Explicabo amet ipsum fugiat aliquam alias.</p>
          </li>

          <li class="timeline-element">
            <h5 class="font-weight-bold dark-grey-text mb-3">Team size increased to 20</h5>
            <p class="grey-text font-small"><time datetime="2018-04-14">14 Apr 2019</time></p>
            <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda ullam adipisci reiciendis porro natus laudantium similique. 
              Explicabo amet ipsum fugiat aliquam alias.</p>
          </li>
        </ol>

      </div>
    </div>
    
  </section>
  <!-- Section -->
  
</div>