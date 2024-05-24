<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Scrollable content -->
        <?php 
        $longContent = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tincidunt erat sit amet neque interdum placerat. Nam consectetur justo ac elit ultrices, sed rhoncus ipsum viverra. Nullam eleifend purus vel felis consectetur commodo. Maecenas in eros auctor, varius mi ut, ultrices lorem. Nulla facilisi. Donec vel vestibulum eros. Quisque sagittis velit in magna fermentum lobortis. Sed et varius sapien. Proin eu viverra sem. Ut vitae vehicula elit. Cras ultricies viverra ligula, vel tincidunt est volutpat in. Pellentesque non est eget est porttitor rutrum. Proin porttitor vel quam nec varius. Nullam volutpat interdum risus, at tempor diam tincidunt nec. Fusce quis mi vel nunc congue vulputate nec eget libero. Proin egestas consectetur ex, in vestibulum nisi tincidunt quis.

        Vivamus consectetur libero et velit gravida, at elementum urna malesuada. Ut congue augue in neque vehicula scelerisque. In hac habitasse platea dictumst. Phasellus congue, libero id condimentum varius, erat est dictum lacus, nec rhoncus nisi quam vel lectus. Phasellus ut odio odio. Morbi vel ultricies tortor. Praesent semper gravida nisi vel vestibulum. Curabitur ac rhoncus nisi. Donec non libero sed libero suscipit varius. Aliquam et sapien risus. Integer sed purus metus.

        Maecenas suscipit lectus vel turpis cursus fringilla. Donec luctus justo vel convallis consectetur. Integer hendrerit feugiat diam, id interdum purus vestibulum eget. Sed vel lectus at metus cursus vestibulum. Integer sit amet semper risus. Phasellus rutrum hendrerit est, nec hendrerit ex malesuada a. Proin accumsan auctor diam, ac eleifend arcu posuere id. Nullam auctor, elit quis facilisis tincidunt, nunc odio interdum lorem, eget placerat ipsum neque vel nisi. Donec gravida rutrum nisi nec efficitur. Nullam in ex vel ligula congue vulputate. Sed ut felis malesuada, aliquet ligula at, tempus eros. Fusce aliquet augue sed neque aliquet, ut convallis ex venenatis. Duis fermentum, eros id posuere sollicitudin, arcu enim rhoncus mi, vel tristique leo velit vel tortor.

        Donec a velit vehicula, fermentum ligula in, convallis sapien. Vestibulum consectetur justo sit amet dui lobortis, vel sagittis libero tristique. Phasellus ornare tortor felis, at semper libero sagittis sed. Nullam ullamcorper quam at turpis"; 
        echo $longContent;
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
